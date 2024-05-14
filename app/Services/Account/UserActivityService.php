<?php
namespace App\Services\Account;

use App\Models\Account\UserActivity;

class UserActivityService
{
     public function __construct(
          public $model = UserActivity::class
     ) {
     }

     public function createActivity($userId, $activity)
     {
          return $this->model::create([
               'user_id' => $userId,
               'activity' => $activity,
               'date_time' => now()
          ]);
     }
}