<?php
namespace App\Actions\Auth;

use App\Enum\Status;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use App\Helpers\Faker\UserDataFake;
use App\Models\AppModules;
use App\Services\Account\UserService;
use App\Services\MedcoApi\MedcoUserService;
use App\Services\Account\UserActivityService;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

class ApiLoginAction
{
     public function __construct(
          private $userActivityService = new UserActivityService,
          private $userService = new UserService,
          private $medcoUserService = new MedcoUserService
     ) {
     }

     public function handle(Request $request)
     {
          $maxInActiveDay = Settings::where('key', 'min_active_day')->first();
          $maxLastLoginDays = $maxInActiveDay?->value ?: 90;

          
          $this->validateModuleAccess($request,$request->email);
          if (!$ptsUser = $this->medcoUserService->findUserByEmail($request->email)) {
               throw new BadRequestException(__('alert.email_not_found'));
          }
          if($ptsUser->person_status==='I'){
               throw new BadRequestException(__('alert.account_in_active'));
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


          $user = $this->userService->createOrUpdateUser($ptsUser->email, [
               'email' => $ptsUser->email,
               'workforce' => $ptsUser->department_name ?: '',
               'identify_provider' => $ptsUser->company_name ?: '',
               'pts_id' => $ptsUser->person_id,
               'platform' => $request->header('platform'),
               'regid' => $request->header('regid'),
               'status' => Status::Active,
               'last_login' => now(),
          ]);

          $userName = [$ptsUser->first_name,$ptsUser->middle_name,$ptsUser->last_name];
          $ptsUser->user_id = $user->id;
          $ptsUser->name = implode(" ",$userName);
          $this->userActivityService->createActivity($user->id, 'login');

          return $ptsUser;
     }


     private function validateModuleAccess(Request $request, $email)
     {
          $appsCategory = $request->header('apps-category');
          if ($appsCategory === 'use-case-2') {
               $module = AppModules::where('key', 'use-case-2')->first();
               if (!$module) {
                    throw new BadRequestException('Dashboard module not found');
               }
               $findModuleAccess = AuthorizationUser::query()
                    ->where('email', 'ILIKE', $email)
                    ->where('modules_id',$module->id)
                    ->first();
               if(!$findModuleAccess){
                    throw new BadRequestException('You are not authorized to use the Production Dashboard');
               }
          }
     }
}