<?php
namespace App\Services\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;

class SafetyCardService
{
     public function riskRank()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetRiskRank
          );
          return $this->makeResult($result);
     }


     public function category()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetCategory
          );
          return $this->makeResult($result);
     }

     public function blockFunction()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetBlockFunction
          );
          return $this->makeResult($result);
     }

     public function location()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetLocation
          );
          return $this->makeResult($result);
     }

     public function division()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetDivision
          );
          return $this->makeResult($result);
     }

     public function department()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetDepartment
          );
          return $this->makeResult($result);
     }

     private function makeResult($result)
     {
          return [
               'en' => @$result['list_answer_eng'] ?: [],
               'id' => @$result['list_answer_ind'] ?: []
          ];
     }
}