<?php
namespace App\Actions\Auth;

use App\Constanta\Constanta;
use App\Enum\Status;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use App\Services\Account\AuthorizationUserService;
use App\Models\AppModules;
use App\Services\Account\UserService;
use App\Services\MedcoApi\MedcoUserService;
use App\Services\Account\UserActivityService;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
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
          $email = strtolower($request->email);
          $tokenMedco = $request->header('tokenmedco');
          $ptsUser = $this->medcoUserService->findUserByEmail($email);

          $this->validateEmailWithTokenMedco($email, $tokenMedco);

          if ($user = $this->userService->findOrCreateByEmail($email)) {
               if ($user->status == Status::InActive){
                    throw new BadRequestException(__('alert.account_in_active'));
               }
          }

          $this->validateAppVersion($request);
          
          $userProperties = [
               'platform' => $request->header('platform'),
               'regid' => $request->header('regid'),
               'status' => Status::Active,
               'last_login' => now(),
          ];   

          if ($ptsUser) {   
               $userProperties = [
                    ...$userProperties,
                    ...[
                         'workforce' => $ptsUser->department_name ?: '',
                         'identify_provider' => $ptsUser->company_name ?: '',
                         'pts_id' => $ptsUser->person_id,
                    ]
               ];
               if ($ptsUser->person_status==='A'){
                    $this->authorizationUserService->findOrCreateByEmailAndModuleID($email, 3); // 3 = Self Screening Module ID
                    $userProperties = [
                         ...$userProperties,
                         ...[
                              'has_pts' => true,
                              'is_pts_active' => true
                         ]
                    ];
               } else {
                    $userProperties = [
                         ...$userProperties,
                         ...[
                              'has_pts' => true,
                              'is_pts_active' => false
                         ]
                    ];
               }

          } else {
               $userProperties = [
                    ...$userProperties,
                    ...[
                         'has_pts' => false,
                         'is_pts_active' => false
                    ]
               ];
          }

          // Grant HSE Authorization to all medco users
          $this->grantHSEAuthorizationForMedcoAccount($email, $ptsUser);
          
          $user = $this->userService->createOrUpdateUser($email, $userProperties);

          $user->person_id = $ptsUser?->person_id;
          $user->user_id = $user->id;
          $user->name = $ptsUser ? implode(" ", [
               $ptsUser?->first_name, 
               $ptsUser?->middle_name, 
               $ptsUser?->last_name  
               ]) : $email;
          $this->userActivityService->createActivity($user->id, 'login');

          $this->validateModuleAccess($request, $request->email);

          return $user;
     }

     private function validateEmailWithTokenMedco(String $email, String $tokenMedco){
          if (empty($tokenMedco)){
               throw new BadRequestException('Your token was invalid !');
          }
          $parts = explode('.', $tokenMedco);
          if (count($parts) < 3){
               throw new BadRequestException('Your token was invalid !');
          }
          $payload = base64_decode($parts[1]);
          $decoded_payload = json_decode($payload, true);
          
          if(!isset($decoded_payload['email'])) {
               throw new BadRequestException('Your token was invalid !');
          }
          if(strtolower($decoded_payload['email']) != $email){ 
               throw new BadRequestException('Your token was invalid !');
          };
     }

     private function validateAppVersion(Request $request){
          $regid = $request->header('regid');
          $minVersion = config('frontend.smartx_min_version');
          $regid = explode('_', $regid);
          $appVersion = $regid[1] ?? '0.0.0';
          $appBundleId = $regid[0] ?? '';
          if ((str_contains($appBundleId, 'com.medco.smartapps') 
               || str_contains($appBundleId, 'com.medcoenergi.smartx')
               || $appBundleId == 'android') 
               && compareVersions($appVersion,$minVersion) == -1){
               throw new BadRequestException('Your application is outdated. Please go to the download page and install the latest version of SmartX');
          }
     }

     private function validateModuleAccess(Request $request, $email)
     {
          $regid = $request->header('regid');
          $appVersion = explode('_', $regid)[1] ?? '0.0.0';
          $appsCategory = $request->header('apps-category');
          if ($appsCategory === 'use-case-2') {
               $module = AppModules::where('key',  'use-case-2')->first();
               if (!$module) {
                    throw new BadRequestException('Module use case 2 not found');
               }
               $findModuleAccess = AuthorizationUser::query()
                    ->where('email', 'ilike', $email)
                    ->where('modules_id', $module->id)
                    ->first();
               if (!$findModuleAccess) {
                    throw new BadRequestException('You are not authorized to access Production Dashboard');
               }
          } else {
               $modules = $this->authorizationUserService->findUserModule($email, $appVersion)->toArray();
               if(count($modules) === 0){
                    throw new BadRequestException('You are not authorized to access SmartX');
               }
          }
     }

     private function grantHSEAuthorizationForMedcoAccount(String $email, object|null $ptsUser){
          $email_regex = '/@(tc\.|sc\.)?medcoenergi\.com$/i';
          $is_medco_email = preg_match($email_regex, $email);

          if ($is_medco_email || $ptsUser) {
              $this->authorizationUserService->findOrCreateByEmailAndModuleID($email, 10); // 10 = HSE Module ID
          }
     }
}