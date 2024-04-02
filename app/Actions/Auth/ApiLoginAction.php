<?php
namespace App\Actions\Auth;

use App\Enum\Status;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use App\Models\AppModules;
use App\Services\Account\AuthorizationUserService;
use App\Services\Account\UserService;
use App\Services\MedcoApi\MedcoUserService;
use App\Services\Account\UserActivityService;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class ApiLoginAction
{
     public function __construct(
          private $userActivityService = new UserActivityService,
          private $authorizationUserService = new AuthorizationUserService,
          private $userService = new UserService,
          private $medcoUserService = new MedcoUserService
     ) {
     }

     public function handle(Request $request)
     {
          $maxInActiveDay = Settings::where('key', 'min_active_day')->first();
          $maxLastLoginDays = $maxInActiveDay?->value ?: 90;
          $email = $request->email;

          $authorization = $this->authorizationUserService->findFirstByEmail($email);
          if ($authorization) {
               throw new BadRequestException('Anda tidak diperbolehkan masuk !');
          }
          $this->validateModuleAccess($request, $request->email);


          if ($user = $this->userService->findOrCreateByEmail($email)) {
               // Validate date last login
               $lastLoginDays = $user->last_login->diffInDays(now());
               if ($lastLoginDays >= $maxLastLoginDays) {
                    $this->userService->updateUser($user->id, [
                         'status' => Status::InActive
                    ]);
                    throw new BadRequestException(__('alert.account_in_active'));
               }
          }

          $userProperties = [
               'platform' => $request->header('platform'),
               'regid' => $request->header('regid'),
               'status' => Status::Active,
               'last_login' => now(),
          ];

          if ($ptsUser = $this->medcoUserService->findUserByEmail($request->email)) {
               if($ptsUser->person_status==='I'){
                    throw new BadRequestException('Anda tidak diperbolehkan masuk !');
               }
               $userProperties = [
                    ...$userProperties,
                    ...[
                         'workforce' => $ptsUser->department_name ?: '',
                         'identify_provider' => $ptsUser->company_name ?: '',
                         'pts_id' => $ptsUser->person_id,
                    ]
               ];
          }

          $user = $this->userService->createOrUpdateUser($ptsUser->email, $userProperties);

          $userName = [$ptsUser->first_name, $ptsUser->middle_name, $ptsUser->last_name];
          $user->person_id = $ptsUser?->person_id;
          $user->user_id = $user->id;
          $user->name = implode(" ", $userName);
          $this->userActivityService->createActivity($user->id, 'login');

          return $user;
     }


     private function validateModuleAccess(Request $request, $email)
     {
          $appsCategory = $request->header('apps-category');
          if ($appsCategory === 'use-case-2') {
               $module = AppModules::where('key', 'use-case-2')->first();
               if (!$module) {
                    throw new BadRequestException('Anda tidak mempunyai akses !');
               }
               $findModuleAccess = AuthorizationUser::query()
                    ->where('email', $email)
                    ->where('modules_id', $module->id)
                    ->first();
               if (!$findModuleAccess) {
                    throw new BadRequestException('Anda tidak mempunyai akses !');
               }
          }
     }
}