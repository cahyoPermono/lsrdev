<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;

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
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::FindUserByPersonIdv2,
               query: [
                    "personid" => $personId
               ]
          );
          if(is_array($restResponse)){
               $restResponse = @$restResponse[0];
          }
          $user = $restResponse ? (object) $restResponse : null;
          if ($user && @$user->supervisor) {
               $user->supervisor = $spv ? $this->findUserByPersonId($user->supervisor, false) : null;
          }
          if($user){
               $user->person_id = $personId;
          }

          return $user;
     }

}