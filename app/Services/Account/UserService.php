<?php
namespace App\Services\Account;

use App\Models\Account\User;

class UserService
{
     public function __construct(
          public $model = User::class
     ) {
     }

     public function findUserByEmail($email)
     {
          return $this->model::where('email', $email)->first();
     }

     public function updateUser($id, $properties)
     {
          return $this->model::where('id', $id)->update($properties);
     }

     public function createOrUpdateUser($email, $properties)
     {
          return $this->model::updateOrCreate(['email' => $email], $properties);
     }
}