<?php
namespace App\Helpers\Faker;

use Illuminate\Support\Facades\Storage;

class UserDataFake
{
     private static function usersData()
     {
          return collect(Storage::json('json/users-by-email.json'));
     }
     public static function findUserByEmail($email)
     {
          return self::usersData()->where('email',$email)->first();
     }
}