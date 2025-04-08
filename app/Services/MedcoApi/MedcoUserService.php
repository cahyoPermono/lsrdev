<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use Barryvdh\Debugbar\Facades\Debugbar;

class MedcoUserService
{
     public function findUserByEmail($email)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::FindUserByEmail,
               query: [
                    "email" => $email
               ]
          );
          return $restResponse ? (object) $restResponse : null;

     }


     public function findUserByPersonId($personId, $spv = true)
     {

          /**
           * MMAPSVC2
           */
          $mmapsvcResponse = MedcoRestful::fetchData(
               url: Url::FindUserByPersonId,
               query: [
                    "personid" => $personId
               ]
          );
          /**
           * MMAPITRAC
           */
          $itracResponse = MedcoRestful::fetchData(
               url: Url::FindUserByPersonIdv2,
               query: [
                    "personid" => $personId
               ]
          );
          if(is_array($itracResponse)){
               $itracResponse = @$itracResponse[0];
          }
          $itracPTSUser = $itracResponse ? (object) $itracResponse : null;
          $mmapsvcUser = $mmapsvcResponse ? (object) $mmapsvcResponse : null;

          
          if ($mmapsvcUser && @$mmapsvcUser->supervisor) {
               $itracPTSUser->supervisor = $spv ? $this->findUserByPersonId($mmapsvcUser->supervisor, false) : null;
          }
          if($itracPTSUser){
	          @$itracPTSUser->cell_phone_number = null;
               $itracPTSUser->person_id = $personId;
               $itracPTSUser->person_status = @$mmapsvcUser->person_status;
               $itracPTSUser->sex = @$mmapsvcUser->sex;
               $itracPTSUser->nationality = @$mmapsvcUser->nationality;
               $itracPTSUser->department = @$itracPTSUser->department_name ?: @$mmapsvcUser->department;
          }

          Debugbar::log($itracPTSUser);
          return $itracPTSUser;
     }
}