<?php
namespace App\Services\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

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
     
     public function reportType()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetReportType
          );
          return $this->makeResult($result);
     }

     public function positibilyOfEvent()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetPossibilityOfEvent
          );
          return $this->makeResult($result);
     }

     public function unsafeBehaviour()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetUnsafeBehaviour
          );
          return $this->makeResult($result);
     }

     public function unsafeCondition()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetUnsafeCondition
          );
          return $this->makeResult($result);
     }

     public function unsafeReason()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetUnsafeReason
          );
          return $this->makeResult($result);
     }

     public function lifeSavingRules()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetLifeSavingRules
          );
          return $this->makeResult($result);
     }

     public function recomendationCategory()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetRecommendationCategory
          );
          return $this->makeResult($result);
     }

     public function recomendationPriority()
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetRecommendationPriority
          );
          return $this->makeResult($result);
     }


     public function recomendationPosition($email)
     {
          $result = MedcoRestful::fetchData(
               url: Url::SafetyCardGetPosition,
               query: [
                    'email' => $email
               ]
          );
          $data = @$result['list_answer'];
          return [
               'en' => $data ?: [],
               'id' => $data ?: [],
          ];
     }

     public function postSafetyCard($params){
          try{
               $result = MedcoRestful::postAction(
                    url : Url::SafetyCardPostSafetyCard,
                    body : $params
               );
               logger("POST SAFETY CARD");
               logger(json_encode($result));
               return $result;
          }catch(\Exception $e){
               logger($e);
               throw new BadRequestException('Error hit api put ic detail');
          }
     }

     private function makeResult($result)
     {
          return [
               'en' => @$result['list_answer_eng'] ?: [],
               'id' => @$result['list_answer_ind'] ?: []
          ];
     }
}