<?php
namespace App\Actions\Auth;

use App\Services\Account\UserActivityService;
use App\Services\Account\UserService;
use Illuminate\Support\Facades\Cache;
use Laililmahfud\Adminportal\Api\JwtToken;

class ApiLogoutAction
{
     public function __construct(
          private $userActivityService = new UserActivityService,
          private $userService = new UserService,
     ) {
     }
     public function handle($email)
     {
          $user = $this->userService->findUserByEmail($email);
          abort_if(!$user, 404);

          $user->update([
               'platform' => null,
               'regid' => null,
               'last_login' => now(),
          ]);
          $this->userActivityService->createActivity($user->id, 'logout');


          JwtToken::blacklist();
          $token = JwtToken::getToken();
          Cache::forget("is-blacklist-token:{$token}");
     }
}