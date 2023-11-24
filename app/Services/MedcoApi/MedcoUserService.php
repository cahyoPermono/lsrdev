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
               url: Url::FindUserByPersonId,
               query: [
                    "personid" => $personId
               ]
          );
          $user = $restResponse ? (object) $restResponse : null;
          if ($user && @$user->supervisor) {
               $user->supervisor = $spv ? $this->findUserByPersonId($user->supervisor, false) : null;
          }

          return $user;
     }

}