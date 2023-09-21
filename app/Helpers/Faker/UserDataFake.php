<?php
namespace App\Helpers\Faker;

use Illuminate\Support\Facades\Storage;

class UserDataFake
{
     private static function usersData()
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
     public static function findUserByEmail($email)
     {
          $user =  self::usersData()->where('email', $email)->first();
          return $user ? (object) $user : null;
     }
}