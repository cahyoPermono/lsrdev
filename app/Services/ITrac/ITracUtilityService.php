<?php
namespace App\Services\ITrac;

use App\Helpers\Url;
use App\Models\Settings;
use App\Helpers\MedcoRestful;
use Barryvdh\Debugbar\Facades\Debugbar;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ITracUtilityService
{
     public function findAllTransportaionType()
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetTransportationType,
          );
          $result = collect($restResponse);

          return $result->map(fn($row) => [
               'id' => @$row['transportation_type_id'],
               'name' => @$row['description'] ." | " .@$row['seat_capacity'] . " seats" ,
          ])
               ->values();
     }

     public function findAllLocation()
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetLocation,
          );
          $result = collect($restResponse);

          return $result->map(fn($row) => [
               'id' => @$row['location_id'],
               'code' => @$row['code'],
               'name' => @$row['name'],
               'field_site_id' => @$row['field_site_id']
          ])
               ->values();
     }
     
     public function findAllPurposeOfVisit()
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetPurpostOfVisit,
          );
          $result = collect($restResponse);

          return $result->map(fn($row) => [
               'id' => @$row['code_id'],
               'code' => @$row['code'],
               'name' => @$row['short_name'],
          ])
               ->values();
     }
     public function findAllPosition()
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetPosition,
          );
          $result = collect($restResponse);

          return $result->map(fn($row) => [
               'id' => @$row['code_id'],
               'code' => @$row['code'],
               'name' => @$row['short_name'],
          ])
               ->values();
     }

     public function findAllCostCenter()
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetCostCenter,
          );
          $result = collect($restResponse);

          return $result->map(fn($row) => [
               'id' => @$row['code_id'],
               'code' => @$row['code'],
               'name' => @$row['short_name'],
          ])
               ->values();
     }

     public function checkRequirementPerson($personId, $position, $departureDate, $status)
     {
          $positionCodes = array_column($this->findAllPosition()->toArray(), 'code');
          if (!in_array( $position, $positionCodes)) {
               throw new BadRequestHttpException( 'Invalid position');
          }
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetMinreqValidity,
               query: [
                    "date" => $departureDate,
                    "personid" => $personId,
                    "positioncode" => $position,
               ]
          );
          Debugbar::info($restResponse);
          if ($restResponse === null) {
               throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, 'Unable to fetch data from PTS');
          }

          if ($status == "OFF-DUTY") {
               return [
                    "is_valid" => true,
                    "competencies" => []
               ];
          }
          
          $isValid = true;
          $competencies = collect($restResponse)->groupBy('competency')->map(function ($group, $competency) use (&$isValid) {
               // A competency is valid if at least ONE certificate in the group is valid
               $iscompetencyValid = $group->contains(function ($item) {
                    return $item['status'] === 'Valid';
               });

               // Minreq is valid when ALL competencies are valid
               if (!$iscompetencyValid) {
                    $isValid = false; 
               }
               
               return [
                    'name' => $competency,
                    'certificates' => $group->map(function ($item) {
                         return [
                              'code'         => $item['certificate_code'],
                              'name'         => $item['certificate_name'] ?? $item['certificate_code'],
                              'valid_until'  => $item['expire_date'] ? date("Y-m-d", strtotime($item['expire_date'])) : null,
                              'status'       => $item['expire_date'] ? $item['status'] : "Not Exists",
                         ];
                    })->toArray(),
               ];
          })->values();

          $result['is_valid'] = $isValid;

          // Only return certificate info if minreq invalid
          $result['competencies'] = !$isValid ? $competencies : [];

          return $result;
     }

     public function findUtilitySetting($key){
          $setting = Settings::where('key', $key)->pluck('value');
          return $setting ? json_decode($setting) : [];
     }
}