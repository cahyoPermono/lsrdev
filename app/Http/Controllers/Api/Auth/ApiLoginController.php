<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helper\Faker\UserDataFake;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Authentication
 */
class ApiLoginController extends ApiController
{

    /**
     * Login
     * 
     * @authentication
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam email string required
     */
    public function __invoke(LoginRequest $request)
    {
        $user = UserDataFake::findUserByEmail($request->email);
    }
}