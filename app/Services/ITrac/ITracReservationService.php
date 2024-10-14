<?php
namespace App\Services\ITrac;

use App\Helpers\Url;
use Illuminate\Http\Request;
use App\Helpers\MedcoRestful;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class ITracReservationService
{
     public function createReservation($postData)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostCreateReservation,
               body : $postData
          );
          $result = collect($restResponse);
          if(@$result['status_code']==Response::HTTP_CREATED){
               return @$result['message'] ?: "Request submitted successfully";
          }
          
          throw new BadRequestException(@$result['message']  ?: @$result['title']);
     }

     public function createPoolCar($postData)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostCreatePoolCar,
               body : $postData
          );
          $result = collect($restResponse);
          if(@$result['status_code']==Response::HTTP_CREATED){
               return @$result['message'] ?: "Request submitted successfully";
          }
          
          throw new BadRequestException(@$result['message']  ?: @$result['title']);
     }

     public function findAllOimApprover($workLocation)
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetRequestApproverList,
          );
          $result = collect($restResponse);

          $result = $result->filter(function($row) use($workLocation){
               return str_contains(strtolower($row['work_location']),strtolower($workLocation));
          });
          return $result->map(fn($row) => [
               'id' => @$row['user_id'],
               'reservation_approver_id' => @$row['reservation_approver_id'],
               'person_id' => @$row['person_id'],
               'name' => @$row['name'],
               'email' => @$row['email'],
          ])
          ->values();
     }

     public function updateOimApproverReservation(Request $request)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostUpdateOimApprover,
               body : [
                    "reservation_id" => $request->reservation_id,
                    "approver" => $request->oim_approver_id,
               ]
          );
          $result = collect($restResponse);
          if(@$result['status_code']==Response::HTTP_CREATED){
               return @$result['message'] ?: "Update oim approver success";
          }

          throw new BadRequestException(@$result['message']  ?: 'Gagal update oim approver');
     }

     public function cancelReservationRequest($reservationId)
     {
          $restResponse = MedcoRestful::postAction(
               url: Url::PostCancelReservationRequest,
               body : [
                    "reservation_id" => $reservationId,
               ]
          );
          $result = collect($restResponse);
          if(@$result['status_code']==Response::HTTP_CREATED){
               return @$result['message'] ?: "Cancel oim approver success";
          }

          throw new BadRequestException(@$result['message']  ?: 'Gagal Cancel oim approver');
     }

     public function findReservationInfo($reservationId){
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetReservationInfo,
               query: [
                    "reservationid" => $reservationId,
               ]
          );

          if(is_array($restResponse)){
               $restResponse = @$restResponse[0];
          }
          $row = $restResponse;
          $additional_info = explode('*|*', @$row['additional_info'] ?: ''); // PTS ID*|*Request Subject='Crew Change’ 
          $comments = explode('*|*',@$row['comments'] ?: ''); //  Schedule*|*Transit Point*|*Justification

          return [
               'title' => @$row['start_location'] . ' - ' . @$row['end_location'],
               'reservation_id' => @$row['reservation_id'],
               'reservation_status' => @$row['reservation_status'],
               'approved_status' => @$row['approved_status'],
               'request_subject' => @$additional_info[1] ?: 'N/A',
               'departure_date' => @$row['departure_date'] ? date('Y-m-d', strtotime($row['departure_date'])) : null,
               'return_date' => @$row['return_date'] ? date('Y-m-d', strtotime($row['return_date'])) : null,
               'schedule' => @$comments[0] ?: '0',
               'transit_point' => @$comments[1] ?: 'Direct to Location',
               'transportation_number' => @$row['transportation_number'] ?: '-',
               'transportation_type' => @$row['transportation_type'] ?: '-',
               'transportation_unit' => @$row['transportation_unit'] ?: '-', 
               'transportation_mode' => @$row['transportation_mode'] ?: '-', 
               'seat_no' => @$row['seat_no'] ?: '-', 
               'status' => @$row['job_activity'],
               'purpose_of_visit' => @$row['purpose_of_visit'] ?: '-', 
               'priority' => @$row['priority'] ?: '-', 
               'accomodation_location' => @$row['accomodation_location'] ?: '-', 
               'justification' => @$comments[2] ?: '-', 
               'approved_by' => @$row['approved_by']
          ];
     }

     public function findAllReservation($personId)
     {
          $CACHE_LIFETIME = 300;//detik
          $futurePersonResult = Cache::remember("GET-FUTURE-PERSON-RESERVATION-{$personId}", $CACHE_LIFETIME, function () use ($personId) {
               return MedcoRestful::fetchData(
                    url: Url::GetFuturePersonReservation,
                    query: [
                         "personid" => $personId,
                         "departure_date" => date('Y-m-d H:i:s')
                    ]
               );
          });

          $futurePoolCarResult = Cache::remember("GET-FUTURE-POOL-CAR-{$personId}", $CACHE_LIFETIME, function () use ($personId) {
               return MedcoRestful::fetchData(
                    url: Url::GetFuturePoolCarRequest,
                    query: [
                         "personid" => $personId,
                         "departure_date" => date('Y-m-d H:i:s')
                    ]
               );
          });

          $futurePerson = collect($futurePersonResult)->map(function ($row) {
               $additional_info = explode('*|*', @$row['additional_info'] ?: '');
               $approved_status = @$row['approved_status'] ?: 'Need Approval';

               $title = @$row['start_location'] . ' - ' . @$row['end_location'];
               $description = @$additional_info[1] ?: 'N/A';
               return [
                    'id' => @$row['reservation_id'],
                    'date' => @$row['departure_date'] ? date('Y-m-d', strtotime($row['departure_date'])) : null,
                    'title' => $title,
                    'description' => $description . ' | ' . $approved_status,
                    'person_id' => trim(@$row['person_id']),
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
}