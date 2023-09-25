<?php

namespace App\Http\Middleware;

use App\Helpers\Optimize;
use Closure;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Api\JwtToken;
use Laililmahfud\Adminportal\Traits\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
        try {
            $token = $request->header('authorization');
            $dataToken = Optimize::cacheForever("data-token:{$token}", function () {
                return $this->auth();
            });
            $isBlacklistToken = Optimize::cacheForever("is-blacklist-token:{$token}", function () {
                return JwtToken::isBlacklist();
            });

            if ($isBlacklistToken || !@$dataToken->person_id) {
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