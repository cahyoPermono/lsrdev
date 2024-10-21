<?php
namespace App\Actions\Itrac;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\ITrac\ITracUtilityService;
use App\Services\ITrac\ITracReservationService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateCrewChangeAction
{
     public function handle(Request $request, $user)
     {
          $isRequirementFulfilled = (new ITracUtilityService)->checkRequirementPerson($request->pts_id);
          if(!$isRequirementFulfilled){
               throw new BadRequestException('Requirements Not Fulfilled');
          }

          // See : https://prnt.sc/L6zHh3nqkiy0
          $postData = [
               'person_id' => intval($request->pts_id),
               'daytime' => Carbon::parse($request->departure_date),
               'return_date' => Carbon::parse($request->return_date),
               'start_loc' => intval($request->from_location_id),
               'end_loc' => intval($request->to_location_id),
               'field_site' => $request->to_location_field_site_id,
               'job_activity' => $request->status,
               'crew' => true,
               'cost_center' => intval($request->coast_center_id),
               'position' => intval($request->position_id),
               'company' => intval($request->pts_company_id),
               'pov' => intval($request->purpose_of_visit_id),
               'approver' => 'INDAPPS',
               'accomm' => $request->accomodation ? true : false,
               'transportation' => 'MEPG_CREW_CHANGE',
               'comments' => implode("*|*",[$request->schedule,$request->transit_point,""]), //Schedule*|*Transit Point*|*Justification=''(concatenated string with *|* as delimiter),
               'additional_info' => implode("*|*",[$user->person_id,"Crew Change"]),// PTS ID*|*Request Subject='Crew Change’ (hardcode)
          ];
          (new ITracReservationService)->createReservation($postData);
     }
}