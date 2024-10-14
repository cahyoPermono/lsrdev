<?php
namespace App\Actions\Itrac;

use App\Services\Utility\TodoTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\ITrac\ITracUtilityService;
use App\Services\ITrac\ITracReservationService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreatePoolCarAction
{
     public function handle(Request $request, $user)
     {
          $isRequirementFulfilled = (new ITracUtilityService)->checkRequirementPerson($request->pts_id);
          if (!$isRequirementFulfilled) {
               throw new BadRequestException('Requirements Not Fulfilled');
          }

          $postData = [
               'person_id' => intval($request->pts_id),
               'daytime' => Carbon::parse($request->date_time),
               'start_loc' => intval($request->from_location_id),
               'end_loc' => intval($request->to_location_id),
               'trans_type' => intval($request->transportation_type_id),
               'justification' => $request->justification,
          ];
          (new ITracReservationService)->createPoolCar($postData);
     }
}