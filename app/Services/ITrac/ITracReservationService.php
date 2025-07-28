<?php
namespace App\Services\ITrac;

use App\Helpers\Url;
use Illuminate\Http\Request;
use App\Helpers\MedcoRestful;
use App\Models\Util\TaskTodo;
use Symfony\Component\HttpFoundation\Response;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use Barryvdh\Debugbar\Facades\Debugbar;

class ITracReservationService
{
     private const TRANSPORT_POOLS = ['MEPG_CREW_CHANGE','MEPG_SPC_TRIP','MEPG_OIM_APPR','MEPG_INTER_FIELD'];
     public function createReservation($postData)
     {
	  Debugbar::info($postData);
          $restResponse = MedcoRestful::postAction(
               url: Url::PostCreateReservation,
               body: $postData
          );
          $result = collect($restResponse);
          logger(Url::PostCreateReservation);
          logger(json_encode($postData));
          logger(json_encode($result));
          if (@$result['status_code'] == Response::HTTP_CREATED) {
               return @$result['message'] ?: "Request submitted successfully";
          }
          
          throw new BadRequestException($this->ptsErrorTranslation(@$result['message']) ?: @$result['title']);
     }

     public function createPoolCar($postData)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostCreatePoolCar,
               body: $postData
          );
          $result = collect($restResponse);
          logger(Url::PostCreateReservation);
          logger(json_encode($postData));
          logger(json_encode($result));
          if (@$result['status_code'] == Response::HTTP_CREATED) {
               return @$result['message'] ?: "Request submitted successfully";
          }

          throw new BadRequestException($this->ptsErrorTranslation(@$result['message']) ?: @$result['title']);
     }

     public function findAllOimApprover($workLocation = null, $role = "OIM")
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetRequestApproverList,
          );
          $result = collect($restResponse);

          if ($workLocation) {
               $result = $result->filter(function ($row) use ($workLocation) {
                    return str_contains(strtolower($row['work_location']), strtolower($workLocation));
               });
          }
          if ($role) {
               $result = $result->filter(function ($row) use ($role) {
                    return str_contains(strtolower($row['role_code']), strtolower($role));
               });
          }
          return $result->map(fn($row) => [
               'id' => @$row['user_id'],
               'reservation_approver_id' => @$row['reservation_approver_id'],
               'person_id' => @$row['person_id'],
               'name' => @$row['name'],
               'email' => @$row['email'],
          ])->values();
     }

     public function updateOimApproverReservation(Request $request)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostUpdateOimApprover,
               body: [
                    "reservation_id" => $request->reservation_id,
                    "approver" => $request->oim_approver_id,
               ]
          );
          $result = collect($restResponse);
          if (@$result['status_code'] == Response::HTTP_CREATED) {
               return @$result['message'] ?: "Update oim approver success";
          }

          throw new BadRequestException(@$result['message'] ?: 'Gagal update oim approver');
     }

     public function cancelReservationRequest($reservationId)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostCancelReservationRequest,
               body: [
                    "reservation_id" => $reservationId,
               ]
          );
          $result = collect($restResponse);
          if (@$result['status_code'] == Response::HTTP_CREATED) {
               return @$result['message'] ?: "Cancel oim approver success";
          }

          throw new BadRequestException(@$result['message'] ?: 'Gagal Cancel oim approver');
     }


     public function approvalReservation(Request $request)
     {
          $action = $request->type == 'approve' ? 'Approve' : 'Reject';
          $restResponse = MedcoRestful::postAction(
               url: Url::PostApprovalReservation,
               body: [
                    "reservation_id" => $request->reservation_id,
                    "approval" => $request->type == 'approve' ? true : false,
                    "comments" => $request->comments ?: ''
               ]
          );
          $result = collect($restResponse);
          if (@$result['status_code'] == Response::HTTP_CREATED) {
               return @$result['message'] ?: $action . " reservation success";
          }

          throw new BadRequestException(@$result['message'] ?: "Gagal {$action} reservation");
     }

     public function findReservationInfo($reservationId, $fromLocation, $toLocation)
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetReservationInfo,
               query: [
                    "reservationid" => $reservationId,
                    "fromlocation" => $fromLocation,
                    "tolocation" => $toLocation
               ]
          );

          if (is_array($restResponse)) {
               $restResponse = @$restResponse[0];
          }
          $row = $restResponse;
          if ($row == null){
               throw new BadRequestException("Reservation not found");
          }
          // If reservation is created and not in a pool, classify as Assigned
          $reservation_status = @$row['reservation_status'] == "Created" && !in_array(@$row['transportation_number'] , self::TRANSPORT_POOLS) ? "Assigned" : @$row['reservation_status']; 
          $approved_status = @$row['approved_status'] ?: 'Need Approval';
          $approved_status = $approved_status === "Disapproved" ? "Rejected" : $approved_status;
          $additional_info = explode('*|*', @$row['additional_info'] ?: ''); //Need accommodation in X*|*Requestor*|*Subject Request*|*Personnel Category*|*Department
          $comments = preg_split("/\r/", $row['comments']);
          $cancel_comment = implode(" ", array_slice($comments, 0, -1)); 
          $comments = explode('*|*', @$comments[array_key_last($comments)] ?: ''); // Schedule*|*Flight Status*|*Home Base*|*Justification

          return [
               'title' => @$row['start_location'] . ' - ' . @$row['end_location'],
               'start_location' => @$row['start_location'],
               'person_id' => @$row['person_id'],
               'reservation_id' => @$row['reservation_id'],
               'reservation_status' => $reservation_status,
               'approved_status' => $approved_status,
               'requestor' => @$additional_info[1],
               'request_subject' => @$additional_info[2] ?: 'N/A',
               'personnel_category' => @$additional_info[3]  ?: null,
               'department' => @$additional_info[4]  ?: '-',
               'departure_date' => @$row['departure_date'] ? date('Y-m-d', strtotime($row['departure_date'])) : null,
               'return_date' => @$row['return_date'] ? date('Y-m-d', strtotime($row['return_date'])) : null,
               'schedule' => @$comments[0] ?: '-',
               'flight_status' => @$comments[1] ?: null,
               'home_base' => @$comments[2] ?: null,
               'justification' => @$comments[3] ?: null,
               'transportation_number' => @$row['transportation_number'] ?: '-',
               'transportation_type' => @$row['transportation_type'] ?: '-',
               'transportation_unit' => @$row['transportation_unit'] ?: '-',
               'transportation_mode' => @$row['transportation_mode'] ?: '-',
               'seat_no' => @$row['seat_no'] ?: '-',
               'status' => @$row['job_activity'],
               'purpose_of_visit' => @$row['purpose_of_visit'] ?: '-',
               'priority' => @$row['priority'] ?: '-',
               'accomodation_location' => @$row['accomodation_location'] ?: '-',
               'approved_by' => @$row['approved_by'],
               'comment' => $cancel_comment
          ];
     }

     public function findAllReservation($personId)
     {
          $futurePersonResult = MedcoRestful::fetchData(
               url: Url::GetFuturePersonReservation,
               query: [
                    "personid" => $personId,
                    "departuredate" => date('Y-m-d')
               ]
          );

          $futurePoolCarResult = MedcoRestful::fetchData(
               url: Url::GetFuturePoolCarRequest,
               query: [
                    "personid" => $personId,
                    "carrierdate" => date('Y-m-d')
               ]
          );

          $futurePerson = collect($futurePersonResult)->map(function ($row) {
               $additional_info = explode('*|*', @$row['additional_info'] ?: '');
               $approved_status = @$row['approved_status'] ?: 'Need Approval';
               $approved_status = $approved_status === "Disapproved" ? "Rejected" : $approved_status;
               $reservation_status =  @$row['reservation_status'];
               $title = @$row['start_location'] . ' - ' . @$row['end_location'];
               $description = @$additional_info[2] ?: 'Crew Change';
               return [
                    'id' => @$row['reservation_id'],
                    'date' => @$row['departure_date'] ? date('Y-m-d', strtotime($row['departure_date'])) : null,
                    'title' => $title,
                    'description' => $description,
                    'approved_status' => $approved_status,
                    'reservation_status' => $reservation_status,
                    'person_id' => intval(trim(@$row['person_id'])),
                    "type" => "special_late_crew",
                    "detail" => null,
               ];
          });

          $futurePoolCar = collect($futurePoolCarResult)->map(function ($row) {
               return [
                    'id' => @$row['carrier_id'],
                    'date' => @$row['carrier_date'] ? date('Y-m-d', strtotime($row['carrier_date'])) : null,
                    'title' => @$row['routing'],
                    'description' => "Pool Car",
                    'person_id' => intval(@$row['person_id']),
                    "type" => "pool_car",
                    'approved_status' => 'Approved',
                    'reservation_status' => 'Created',
                    "detail" => [
                         "routing" => @$row['routing'],
                         "carrier_id" => @$row['carrier_id'],
                         "carrier_number" => "-",
                         "departure_date" => @$row['carrier_date'] ? date('Y-m-d', strtotime($row['carrier_date'])) : null,
                         "transportation_type" => @$row['transportation_type'] ?: '-',
                         "transportation_unit" => @$row['transportation_unit'] ?: '-',
                         "carrier_description" => @$row['carrier_description'] ?: '-',
                         "carrier_scheduled" => @$row['carrier_scheduled'] ?: '-',
                    ]
               ];
          });
          return collect([
               ...$futurePerson,
               ...$futurePoolCar
          ])
               ->unique()
               ->sortByDesc('date')
               ->values();
     }


     public function findAllReservationOimApproval($personId)
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetReservationByPersonId,
               query: [
                    "approvedbypersonid" => $personId,
               ]
          );

          return collect($restResponse)
               ->whereNull('approved_status')
               ->where('reservation_status', '!=', 'Cancelled')
               ->values()
               ->map(function ($row) {
                    $title = implode(" ", [@$row['first_name'], @$row['middle_name'], @$row['last_name']]);
                    $departure_date = @$row['departure_date'];
                    $departure_date = $departure_date ? date('d M Y', strtotime($departure_date)) : '-';
                    $description = $departure_date . " | " . @$row['start_location'] . ' - ' . @$row['end_location'];
                    return [
                         'id' => @$row['reservation_id'],
                         'title' => $title,
                         'description' => $description,
                         "type" => @$row['job_activity'],
                    ];
               });
          ;
     }

     public function calculateTaskTodo($email, $ptsId)
     {
          $totalTask = 0;
          $taskReservation = MedcoRestful::fetchData(
               url: Url::GetReservationByPersonId,
               query: [
                    "approvedbypersonid" => $ptsId,
               ]
          );
          if ($taskReservation) {
               $totalTask = collect($taskReservation)
                    ->whereNull('approved_status')
                    ->where('reservation_status', '!=', 'Cancelled')
                    ->count();
          }

          TaskTodo::updateOrCreate([
               'email' => $email,
          ], [
               'email' => $email,
               'module_key' => 'oim_approval',
               'total_task' => $totalTask,
          ]);
     }

     private function ptsErrorTranslation($message){
          logger($message);
          preg_match('/Message: (.*?)\nStackTrace:/s', $message, $matches);
          $errorMessage = $matches[1];
          if (str_contains( $errorMessage, 'Transportation ID not found')){
               return "Transportation not available for the selected date/location";
          } else if (str_contains($errorMessage, 'CARRIER_PERS_RES_DOUBLEBOOKING_IO')){
               return "Double booking for the selected date";
          } else if (str_contains($errorMessage, 'CARRIER_PERS_RES_PERSON_INACTIVE')){
               return "Personnel's PTS status is INACTIVE";
          }
          return "An error has occured:\n $message";
     }
}