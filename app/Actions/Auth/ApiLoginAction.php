<?php
namespace App\Actions\Auth;

use App\Enum\Status;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use App\Services\Account\AuthorizationUserService;
use App\Models\AppModules;
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
          $tokenMedco = $request->header('tokenmedco');
          $ptsUser = $this->medcoUserService->findUserByEmail($email);

          $this->validateEmailWithTokenMedco($email, $tokenMedco);


          if ($user = $this->userService->findOrCreateByEmail(strtolower($email))) {
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

          if ($ptsUser) {   
               $this->userService->updateUser($user->id, [
                    'has_pts' => true
               ]);
               $userProperties = [
                    ...$userProperties,
                    ...[
                         'workforce' => $ptsUser->department_name ?: '',
                         'identify_provider' => $ptsUser->company_name ?: '',
                         'pts_id' => $ptsUser->person_id,
                    ]
               ];
               if ($ptsUser->person_status==='A'){
                    $this->handlePTSActive($email, $user->id);
               } else {
                    $this->handlePTSInactive($email, $user->id);
               }

          } else {
               $this->handleNoPTS($email, $user->id);
          }
          
          $user = $this->userService->createOrUpdateUser(strtolower($email), $userProperties);

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
          if(strtolower($decoded_payload['email']) != strtolower($email)){ 
               throw new BadRequestException('Your token was invalid !');
          };
     }

     private function validateModuleAccess(Request $request, $email)
     {
          $appsCategory = $request->header('apps-category');
          if ($appsCategory === 'use-case-2') {
               $module = AppModules::where('key', 'use-case-2')->first();
               if (!$module) {
                    throw new BadRequestException('Module use case 2 not found');
               }
               $findModuleAccess = AuthorizationUser::query()
                    ->where('email', 'ilike', $email)
                    ->where('modules_id', $module->id)
                    ->first();
               if (!$findModuleAccess) {
                    throw new BadRequestException('You are not authorized to use the Production Dashboard app');
               }
          } else {
               $modules = $this->authorizationUserService->findUserModule($email)->toArray();
               if(count($modules) === 0){
                    throw new BadRequestException('You are not authorized to use SmartX');
               }
          }
     }

     private function grantHSEAuthorization(String $email){
          $email_regex = '/@(tc\.|sc\.)?medcoenergi\.com$/i';

          if (preg_match($email_regex, $email)) {
              $this->authorizationUserService->findOrCreateByEmailAndModuleID(strtolower($email), 10); // 10 = HSE Module ID
          }
     }

     private function handlePTSActive(String $email, String $userId){
          $this->authorizationUserService->findOrCreateByEmailAndModuleID(strtolower($email), 3); // 3 = Self Screening Module ID
          $this->userService->updateUser($userId, [
               'is_pts_active' => true
          ]);
     }

     private function handlePTSInactive(String $email, String $userId){
          $this->userService->updateUser($userId, [
               'is_pts_active' => false
          ]);
          $this->grantHSEAuthorization($email);
     }

     private function handleNoPTS(String $email, String $userId){
          $this->userService->updateUser($userId, [
               'has_pts' => false,
               'is_pts_active' => false
          ]);
          $this->grantHSEAuthorization($email);
     }

}