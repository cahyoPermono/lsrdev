<?php

namespace App\Http\Middleware;

use App\Models\AuthorizationUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Traits\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserAuthorizationMiddleware
{
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
        if (!$userEmail = @$dataToken->email) {
            return $this->unauthorized('Your token was invalid !', Error::INVALID_TOKEN);
        }

        $userAccess = AuthorizationUser::query()
            ->join('app_modules', 'authorization_users.modules_id', 'app_modules.id')
            ->where('authorization_users.email', $userEmail)
            ->where('app_modules.key', $moduleKey)
            ->first();
        if(!$userAccess){
            return $this->unauthorized("You don't have access to this resource");
        }
        return $next($request);
    }
}
