<?php

namespace App\Http\Middleware;

use App\Models\AuthorizationUser;
use App\Services\Account\UserService;
use App\Services\AppModulesService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Traits\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserAuthorizationMiddleware
{
    const HSE_MIN_VERSION = "0.3.9";
    const ITRAC_MIN_VERSION = "1.2.0";
    const HSE_MODULE_KEY = 'hse';
    const ITRAC_MODULE_KEY = 'itrac';
    public function __construct(
        public $model = AuthorizationUser::class,
        private $userService = new UserService,
        private $appModulesService = new AppModulesService
    ) {
    }

    use JsonResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $moduleKey): Response
    {
        $token = $request->header('authorization');
        $dataToken = Cache::get("data-token:{$token}");
        $regid = $request->header('regid');
        $appVersion = explode('_', $regid)[1] ?? '0.0.0';
        if (!$userEmail = @$dataToken->email) {
            return $this->unauthorized('Your token was invalid !', Error::INVALID_TOKEN);
        }

        $excludeModuleKey = [];
        $ptsModuleKeys = $this->appModulesService->getPTSModulesKeys()->toArray();

        $user = $this->userService->findUserByEmail($userEmail);

        // if user is not an active PTS user, exclude PTS modules
        if (!$user->is_pts_active) {   
            $excludeModuleKey = array_merge($excludeModuleKey, $ptsModuleKeys);
        } 
        // Handle transition from phase 1 to hse, exclude if version < 0.3.9
        if (compareVersions($appVersion,$this::HSE_MIN_VERSION) == -1){
            $excludeModuleKey = array_merge($excludeModuleKey, [$this::HSE_MODULE_KEY]);
        }
        // Handle transition from 1.1.2 to 1.2.1, exclude if version < 1.2.0
        if (compareVersions($appVersion,$this::ITRAC_MIN_VERSION) == -1){
            $excludeModuleKey = array_merge($excludeModuleKey, [$this::ITRAC_MODULE_KEY]);
        }

        $userAccess = AuthorizationUser::query()
            ->join('app_modules', 'authorization_users.modules_id', 'app_modules.id')
            ->where('authorization_users.email', 'ilike', $userEmail)
            ->whereNotIn('app_modules.key',$excludeModuleKey)
            ->where('app_modules.key', $moduleKey)
            ->first();
        if(!$userAccess){
            return $this->unauthorized("You don't have access to this resource");
        }
        return $next($request);
    }


}
