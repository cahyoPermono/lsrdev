<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\ApiLogoutAction;
use App\Http\Controllers\Controller;
use App\Services\Account\AuthorizationUserService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Authentication
 */
class ApiUserAuthorizationController extends ApiController
{
    public function __construct(
        private AuthorizationUserService $authorizationUserService
    ){}

    /**
     * Logout
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "Good Bye !"
     * }
     * 
     */
    public function logout(Request $request, ApiLogoutAction $apiLogoutAction)
    {
        $email = $this->auth()->email;
        $apiLogoutAction->handle($email);
        return $this->sendMessage('Good Bye !');
    }

    /**
     * User Module Access
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "label": "Self Screening",
     *       "key": "self-screening",
     *       "icon": "http://crocodic.test/medco-sa/public/fake/self-screening.png",
     *       "sorting": 1,
     *       "is_module": true,
     *       "subs": [
     *           {
     *           "label": "Other Screening",
     *           "key": "other-screening",
     *           "icon": "http://crocodic.test/medco-sa/public/uploads/image/mfxHcS6Q4ygZFPw2XlpeK3Vq65WQYdU9Se6LUgDT.png",
     *           "sorting": 5,
     *           "is_module": true
     *           }
     *       ]
     *       },
     *       {
     *       "label": "PTW Issuer",
     *       "key": "ptw-issuer",
     *       "icon": "http://crocodic.test/medco-sa/public/fake/pwt-issuer.png",
     *       "sorting": 2,
     *       "is_module": true,
     *       "subs": []
     *       },
     *       {
     *       "label": "Isolation",
     *       "key": "isolation",
     *       "icon": "http://crocodic.test/medco-sa/public/fake/isolation.png",
     *       "sorting": 2,
     *       "is_module": true,
     *       "subs": []
     *       }
     *   ]
     *  }
     * 
     */
    public function authorization(Request $request)
    {
        $user = $this->auth();
        $modules = $this->authorizationUserService->findUserModule($user->email);
        return $this->sendSuccess($modules);
    }
}