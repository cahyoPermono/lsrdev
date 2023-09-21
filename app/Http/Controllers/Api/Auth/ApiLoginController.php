<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Faker\UserDataFake;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\LoginResponseResource;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Authentication
 */
class ApiLoginController extends ApiController
{

    /**
     * Login
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam email string required ex : ade.anwar@medcoenergi.com
     * 
     * @response 400 {
     *   "status": 400,
     *   "error": "bad_request",
     *   "message": "The email is not registered in the PTS database. Please contact admin"
     * }
     */
    public function __invoke(LoginRequest $request)
    {
        if (!$user = UserDataFake::findUserByEmail($request->email)) {
            return $this->badRequest(__('alert.email_not_found'));
        }
        return $this->sendSuccess(new LoginResponseResource($user));
    }
}