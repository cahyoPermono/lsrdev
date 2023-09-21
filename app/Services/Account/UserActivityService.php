<?php
namespace App\Services\Account;

use App\Models\Account\UserActivity;

class UserActivityService
{
     public function __construct(
          public $model = UserActivity::class
     ) {
     }
}