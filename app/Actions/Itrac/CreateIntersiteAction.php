<?php
namespace App\Actions\Itrac;

use App\Services\Utility\TodoTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\ITrac\ITracUtilityService;
use App\Services\ITrac\ITracReservationService;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class CreateIntersiteAction
{
   public function handle(Request $request, $user)
   {
      $position = array_filter((new ITracUtilityService)->findAllPosition()->toArray(), function($position) use ($request) {
         return $position['id'] === intval($request->position_id);
      });
      $position = reset($position);
      $isRequirementFulfilled = (new ITracUtilityService)->checkRequirementPerson(
         $request->pts_id,
         $position['code'],
         $request->departure_date,
         $request->status
      );
      if(!$isRequirementFulfilled['is_valid']){
         throw new BadRequestException('Requirements Not Fulfilled');
      }

      $subject_request = $request->subject_request;
      $postData = [
         'person_id' => intval($request->pts_id),
         'daytime' => $request->departure_date_time,
         'start_loc' => intval($request->from_location_id),
         'end_loc' => intval($request->to_location_id),
         // 'field_site' => $request->to_location_field_site_id,
         'job_activity' => 'Intersite',
         'crew' => $subject_request == 'scheduled_intersite' ? true : false,
         'cost_center' => intval($request->cost_center_id ?? 1),
         'position' => intval($request->position_id),
         'company' => intval($request->pts_company_id),
         'pov' => intval($request->purpose_of_visit_id),
         'approver' => $subject_request == 'scheduled_intersite' ? 'INDAPPS': $request->approver_id,
         'accomm' => $request->accomodation ? true : false,
         'transportation' => 'MEPG_INTER_FIELD',
         'comments' => implode("*|*",[$request->schedule ?? '','',
         '',$request->justification]), //Schedule*|*Home Base*|*Flight Status*|*Justification
         'additional_info' => implode("*|*",[
            $user->person_id, // Requestor
            $subject_request == 'scheduled_intersite' ? 'Scheduled Intersite' : 'Unscheduled Intersite', // Subject of Request
            '', //Personnel Category
            $request->department_name, // Department
         ]),// Requestor*|*"Crew Change" *|*Personnel Category*|*Department
      ];
      (new ITracReservationService)->createReservation($postData);
      if ($request->subject_request == 'unscheduled_intersite') {
        (new ITracReservationService)->calculateTaskTodo($request->approver_email, $request->approver_id);
      }

   }
}