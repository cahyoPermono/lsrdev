<?php
namespace App\Actions\Itrac;

use App\Services\Utility\TodoTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\ITrac\ITracUtilityService;
use App\Services\ITrac\ITracReservationService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateSpecialTripAction
{
     public function handle(Request $request, $user)
     {
          $isRequirementFulfilled = (new ITracUtilityService)->checkRequirementPerson($request->pts_id);
          if (!$isRequirementFulfilled) {
               throw new BadRequestException('Requirements Not Fulfilled');
          }

          $subject_request = $request->subject_request;
          $postData = [
               'person_id' => intval($request->pts_id),
               'daytime' => Carbon::parse($request->departure_date),
               'return_date' => Carbon::parse($request->return_date),
               'start_loc' => intval($request->from_location_id),
               'end_loc' => intval($request->to_location_id),
               'field_site' => $request->to_location_field_site_id,
               'job_activity' => $subject_request == 'special_trip' ? 'Special Trip' : $request->status,
               'crew' => true,
               'cost_center' => intval($request->coast_center_id),
               'position' => intval($request->position_id),
               'company' => intval($request->pts_company_id),
               'pov' => intval($request->purpose_of_visit_id),
               'approver' => $request->oim_approver_id,
               'accomm' => $request->accomodation ? true : false,
               'transportation' => 'ON_LV_TEST',
               'comments' => implode("*|*", [$subject_request == 'special_trip' ? '' : $request->schedule, $request->transit_point, $request->justification]), //Schedule*|*Transit Point*|*Justification=''(concatenated string with *|* as delimiter),
               'additional_info' => implode("*|*", [$user->person_id, $subject_request == 'special_trip' ? 'Special Trip' : 'Late Crew Change Registration']),// PTS ID*|*Request Subject='Crew Change’ (hardcode)
          ];
          (new ITracReservationService)->createReservation($postData);
          (new TodoTaskService)->incrementTaskByEmail($request->oim_approver_email);
     }
}