<?php
namespace App\Helper\Faker;

use Illuminate\Support\Facades\Storage;

class UserDataFake
{
     private static function jsonData(){
          return Storage::json('json/users-by-email.json');
     }
     public static function findUserByEmail($email)
     {
          $users = self::jsonData();
          return $users;
     }
}