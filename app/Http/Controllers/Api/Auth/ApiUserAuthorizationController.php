<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\ApiLogoutAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Authentication
 */
class ApiUserAuthorizationController extends ApiController
{

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
     *       "subs": [
     *           {
     *           "label": "Other Screening",
     *           "key": "other-screening"
     *           }
     *       ]
     *       },
     *       {
     *       "label": "PWT Issuer",
     *       "key": "ptw-issuer",
     *       "icon": "http://crocodic.test/medco-sa/public/fake/pwt-issuer.png",
     *       "sorting": 2,
     *       "subs": []
     *       },
     *       {
     *       "label": "Isolation",
     *       "key": "isolation",
     *       "icon": "http://crocodic.test/medco-sa/public/fake/isolation.png",
     *       "sorting": 2,
     *       "subs": []
     *       }
     *   ]
     *  }
     * 
     */
    public function authorization(Request $request)
    {
        $authorization = [
            [
                "label" => "Self Screening",
                "key" => "self-screening",
                "icon" => asset("fake/self-screening.png"),
                "sorting" => 1,
                "subs" => [
                    [
                        "label" => "Other Screening",
                        "key" => "other-screening"
                    ]
                ]
            ],
            [
                "label" => "PWT Issuer",
                "key" => "ptw-issuer",
                "icon" => asset("fake/pwt-issuer.png"),
                "sorting" => 2,
                "subs" => []
            ],
            [
                "label" => "Isolation",
                "key" => "isolation",
                "icon" => asset("fake/isolation.png"),
                "sorting" => 2,
                "subs" => []
            ]
        ];
        return $this->sendSuccess($authorization);
    }
}