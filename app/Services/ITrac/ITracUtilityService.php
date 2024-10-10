<?php
namespace App\Services\ITrac;

use App\Helpers\Url;
use App\Models\Settings;
use App\Helpers\MedcoRestful;

class ITracUtilityService
{
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