<?php

namespace App\Http\Middleware;

use App\Helpers\Optimize;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Api\JwtToken;
use Laililmahfud\Adminportal\Traits\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use \Barryvdh\Debugbar\Facades\Debugbar;
use Firebase\JWT\ExpiredException;

class ApiPrivateMiddleware
{
    use JsonResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            JwtToken::decode();
        } catch (ExpiredException) {
            return $this->unauthorized("Your token is expired !", Error::EXPIRED_TOKEN);
        }
        try {
            $token = $request->header('authorization');
            $dataToken = Optimize::cacheRememberForever("data-token:{$token}", function () {
                return $this->auth();
            });
            $isBlacklistToken = Optimize::cacheForever("is-blacklist-token:{$token}", JwtToken::isBlacklist());

            if ($isBlacklistToken) {
                return $this->unauthorized('Your token was not found !', Error::FORBIDDEN);
            }
            if (@$dataToken->regid != $request->header('regid')) {
                return $this->unauthorized('Your token was invalid !', Error::INVALID_TOKEN);
            }

            return $next($request);
        } catch (\Exception $e) {
            logger($e);
        }
        return $this->unauthorized('Your token was not found !', Error::FORBIDDEN);
    }
}