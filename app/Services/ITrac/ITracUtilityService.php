<?php
namespace App\Services\ITrac;

use App\Helpers\Url;
use App\Models\Settings;
use App\Helpers\MedcoRestful;

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

     public function checkRequirementPerson($personId)
     {
          $restResponse = MedcoRestful::fetchData(
               url: Url::ListCertificate,
               query: [
                    "personid" => $personId
               ]
          );
          if (!$restResponse) {
               return [];
          }
          
          $requiredCertificates = ["1-HSEORI","2-MCU"];
          $findRequiredCerfiticate = collect(@$restResponse['certificates'] ?: [])->whereIn('certificate_code',$requiredCertificates)->count();

          return $findRequiredCerfiticate==count($requiredCertificates);
     }

     public function findUtilitySetting($key){
          $setting = Settings::where('key',$key)->value('value');
          return $setting ? json_decode($setting) : [];
     }
}