<?php
namespace App\Actions\Auth;

use App\Enum\Status;
use App\Helpers\Faker\UserDataFake;
use App\Services\Account\UserService;
use App\Services\MedcoApi\MedcoUser;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class ApiLoginAction
{
     public function __construct(
          private $userService = new UserService,
          private $medcoUser = new MedcoUser
     ) {
     }

     public function handle(Request $request)
     {

          // TODO : get this from setting database
          $maxLastLoginDays = 90;

          if (!$ptsUser = $this->medcoUser->findUserByEmail($request->email)) {
               throw new BadRequestException(__('alert.email_not_found'));
          }
          if ($user = $this->userService->findUserByEmail($ptsUser->email)) {
               // Validate date last login
               $lastLoginDays = $user->last_login->diffInDays(now());
               if ($lastLoginDays >= $maxLastLoginDays) {
                    $this->userService->updateUser($user->id, [
                         'status' => Status::InActive
                    ]);
                    throw new BadRequestException(__('alert.account_in_active'));
               }
          }


          // Todo : send fcm force logout last user
          $this->userService->createOrUpdateUser($ptsUser->email, [
               'email' => $ptsUser->email,
               'workforce' => $ptsUser->department_name,
               'identify_provider' => $ptsUser->company_name,
               'pts_id' => $ptsUser->person_id,
               'platform' => $request->header('platform'),
               'regid' => $request->header('regid'),
               'status' => Status::Active,
               'last_login' => now(),
          ]);


          return $ptsUser;
     }
}