<?php
namespace App\Services\MedcoApi;

use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MedcoUserService
{
     private static function fakeUsers()
     {
          /**
           *  {
           *     "email": "abdul.hakim@contractor.medcoenergi.com",
           *     "person_id": 19823818,
           *     "first_name": "Abdul",
           *     "middle_name": "",
           *     "last_name": "HAKIM",
           *     "sex": "M",
           *     "nationality": "Indonesia",
           *     "department_name": "Information Technology",
           *     "company_name": "JASNIKOM GEMANUSA PT",
           *     "person_status": "A",
           *     "supervisor": 13979786,
           *     "b2b_person_id": 19821141
           *  }
           */
          return collect(Storage::json('json/users-by-email.json'));
     }
     public function __construct(
          protected string $url
     )
     {
          $this->url = Config::get('services.api.base_url');
     }
     public function findUserByEmail($email)
     {
          $apiUrl = $this->url . "MMAPSVC/PTS/GetDataByEmail?email=$email";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);

          if($parseResponse['status_code'] == StatusCode::SUCCESS) {
               $user = $parseResponse['data']['email'];
               return $user ? (object) $user : null;

          }


          return MedcoApi::notFoundResponse();
          // $user = self::fakeUsers()->where('email', $email)->first();
          // return $user ? (object) $user : null;

     }

     public function findUserByPersonId($personId)
     {
          $apiUrl = $this->url . "MMAPSVC/PTS/GetDataByPersonId?personid=$personId";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);

          if($parseResponse['status_code'] == StatusCode::SUCCESS) {
               $user = $parseResponse['data']['person_id'] ? (object) $parseResponse['data']['person_id'] : null;

               if($user && @$user->supervisor){
                    $user->supervisor = $this->findUserByPersonId($user->supervisor);
               }
               return $user;

          }
          return MedcoApi::notFoundResponse();
          // $user = self::fakeUsers()->where('person_id', $personId)->first();
          // $user =  $user ? (object) $user : null;
          // if($user && @$user->supervisor){
          //      $user->supervisor = $this->findUserByPersonId($user->supervisor);
          // }
          // return $user;
     }
}