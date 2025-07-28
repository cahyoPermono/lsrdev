<?php
namespace App\Actions\Itrac;

use Carbon\Carbon;
use App\Http\Requests\Api\CrewChange\CreateCrewChangeRequest;
use App\Services\ITrac\ITracUtilityService;
use App\Services\ITrac\ITracReservationService;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class CreateCrewChangeAction
{
     public function __construct(
        private ITracUtilityService $iTracUtilityService,
        private ITracReservationService $iTracReservationService
    ) {
    }
     public function handle(CreateCrewChangeRequest $request, $user)
     {
          if ($request->departure_date && Carbon::parse($request->departure_date)->lt(Carbon::create(2025, 8, 1))) {
          // The departure_date is before August 1, 2025
               throw new BadRequestException('Departure starts from 01 Aug 2025');
          }
          $position = array_filter($this->iTracUtilityService->findAllPosition()->toArray(), function($position) use ($request) {
               return $position['id'] === intval($request->position_id);
          });

          $date = Carbon::parse($request->departure_date);
          $threeDaysFromNow = Carbon::now()->addDays(3)->startOfDay();

          if ($date->lessThan($threeDaysFromNow)) {
               throw new BadRequestException('Departure date must be >= 3 days from now');
          }
          $position = reset($position);

          $isRequirementFulfilled = $this->iTracUtilityService->checkRequirementPerson(
               $request->pts_id,
               $position['code'],
               $request->departure_date,
               $request->status
          );
          if(!$isRequirementFulfilled['is_valid']){
               throw new BadRequestException('Requirements Not Fulfilled');
          }

          // See : https://prnt.sc/L6zHh3nqkiy0
          $postData = [
               'person_id' => intval(value: $request->pts_id),
               'daytime' => $request->departure_date,
               'return_date' => $request->return_date,
               'start_loc' => intval($request->from_location_id),
               'end_loc' => intval($request->to_location_id),
               'job_activity' => $request->status,
               'crew' => true,
               'cost_center' => intval($request->cost_center_id ?? 1),
               'position' => intval($request->position_id),
               'company' => intval($request->pts_company_id),
               'pov' => intval($request->purpose_of_visit_id),
               'approver' => 'INDAPPS',
               'accomm' => $request->accomodation ? true : false,
               'transportation' => 'MEPG_CREW_CHANGE',
               'schedule' => $request->schedule,
               'comments' => implode("*|*",[$request->schedule,$request->flight_status,$request->home_base,$request->justification]), //Schedule*|*Flight Status*|*Home Base*|*Justification
               'additional_info' => implode("*|*",[
                    $user->person_id,
                    "Crew Change",
                    $request->personnel_category_name, 
                    $request->department_name, 
               ]),// Requestor*|*"Crew Change" *|*Personnel Category*|*Department
          ];
          $this->iTracReservationService->createReservation($postData);
     }
}