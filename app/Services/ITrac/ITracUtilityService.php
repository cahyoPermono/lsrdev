<?php
namespace App\Services\ITrac;

use App\Helpers\Url;
use App\Models\Settings;
use App\Helpers\MedcoRestful;
use App\Models\ITrac\ITracPersonnelCategory;
use App\Models\ITrac\ITracUtility;
use App\Models\ITrac\ITracSchedule;
use Barryvdh\Debugbar\Facades\Debugbar;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

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



     public function findAllLocation($type=null)
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetLocation,
          );

          $result = collect($restResponse);

          return $result
               ->filter(function ($row) use ($type) {
                    if ($type === 'field_site') {
                         return !empty($row['field_site_id']);
                    } elseif ($type === 'terminal') {
                         return !empty($row['terminal_id']);
                    }
                    return true; // when $isFieldSite is null
               })
               ->map(fn($row) => [
                    'id' => @$row['location_id'],
                    'code' => @$row['code'],
                    'name' => @$row['name'],
                    'field_site_id' => @$row['field_site_id'],
                    'terminal_id' => @$row['terminal_id']
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

     public function checkRequirementPerson($personId, $positionCode, $departureDate, $status)
     {
          $positionCodes = array_column($this->findAllPosition()->toArray(), 'code');
          if (!in_array( $positionCode, $positionCodes)) {
               throw new BadRequestException( 'Invalid position');
          }
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetMinreqValidity,
               query: [
                    "date" => $departureDate,
                    "personid" => $personId,
                    "positioncode" => $positionCode,
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
          $setting = ITracUtility::where('key', $key)->pluck('value');
          return $setting ? json_decode($setting) : [];
     }

     public function getPersonnelCategories(){
          $personnelCategories = ITracPersonnelCategory::orderBy('id', 'asc')->get(['id', 'code','name','days']);
          return $personnelCategories ? json_decode($personnelCategories) : [];
     }
	 
	public function getIntersiteSchedules(?string $from = null, ?string $to = null)
	{
		return ITracSchedule::when($from, fn($q) => $q->whereRaw('LOWER(from_location) = ?', [strtolower($from)]))
							->when($to, fn($q) => $q->whereRaw('LOWER(to_location) = ?', [strtolower($to)]))
							->orderBy('departure_time')
							->get();
	}


     public function getCompanies(){
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetCompany,
          );
          $result = collect($restResponse);
          return $result->map(fn($row) => [
               'id' => @$row['company_id'],
               'code' => @$row['company_code'],
               'name' => @$row['company_name'],
          ])
               ->values();
     }
}