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
use Illuminate\Validation\UnauthorizedException;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use Laililmahfud\Adminportal\Api\JwtToken;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

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

          $tokenMedco = $request->header('tokenmedco');
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
          if(strtolower($decoded_payload['email']) != strtolower($request->email)){ 
               throw new BadRequestException('Your token was invalid !');
          }


          
          $this->validateModuleAccess($request,$request->email);
          if (!$ptsUser = $this->medcoUserService->findUserByEmail($request->email)) {
               throw new BadRequestException(__('alert.email_not_found'));
          }
          if($ptsUser->person_status==='I'){
               throw new BadRequestException('Your PTS status is inactive. Please contact admin');
          }

          $email = $request->email;

          $authorization = $this->authorizationUserService->findFirstByEmail($email);
          if (!$authorization) {
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

          if ($ptsUser = $this->medcoUserService->findUserByEmail($email)) {
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

          $user = $this->userService->createOrUpdateUser($email, $userProperties);

          $user->person_id = $ptsUser?->person_id;
          $user->user_id = $user->id;
          $user->name = $ptsUser ? implode(" ", [$ptsUser?->first_name, $ptsUser?->middle_name, $ptsUser?->last_name]) : $email;
          $this->userActivityService->createActivity($user->id, 'login');

          return $user;
     }



     private function validateModuleAccess(Request $request, $email)
     {
          $appsCategory = $request->header('apps-category');
          if ($appsCategory === 'use-case-2') {
               $module = AppModules::where('key', 'use-case-2')->first();
               if (!$module) {
                    throw new InternalErrorException('Dashboard module does not exist');
               }
               $findModuleAccess = AuthorizationUser::query()
                    ->where('email', $email)
                    ->where('modules_id', $module->id)
                    ->first();
               if (!$findModuleAccess) {
                    throw new BadRequestException('You are not authorized to use the Production Dashboard!');
               }
          }
     }
}