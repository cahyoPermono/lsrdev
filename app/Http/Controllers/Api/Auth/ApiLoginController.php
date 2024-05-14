<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\ApiLoginAction;
use App\Helpers\Faker\UserDataFake;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\LoginResponseResource;
use App\Services\Account\UserService;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

/**
 * @group Authentication
 * @sorting 1
 */
class ApiLoginController extends ApiController
{
    public function __construct(
        private UserService $userService
    ) {
    }
    /**
     * Login
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam email string required ex : abdul.hakim@contractor.medcoenergi.com
     * 
     * @response 400 {
     *   "status": 400,
     *   "error": "bad_request",
     *   "message": "The email is not registered in the PTS database. Please contact admin"
     * }
     * 
     * @response 200 {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "email": "abdul.hakim@contractor.medcoenergi.com",
     *       "token": {
     *       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2OTUzNTE1OTQsImlzcyI6Ik1FRENPIFNNQVJUIEFQUFMiLCJpYXQiOjE2OTUyNjUxOTQsIm5iZiI6MTY5NTI2NTE5NCwianRpIjoiazExalBUMlAxVTc1OWZUIiwiZGF0YSI6eyJlbWFpbCI6Ik9DWTJCeUQyanJNSEpGT0E2YUJwaUgzdzdmQkswaTl6cW5ybklveWxRVnRvVUZrbDdjaGRnTFU9IiwicGVyc29uX2lkIjoiYWVMNDNWKzBHZDVXSnIweldoNGV3aTZwaFdsZUhmRGEiLCJyZWdpZCI6IjEyMzQ1NiJ9fQ.OlmgVkLVrm02Za4uOat2IEP_Ny5miV-GJ-_s9DzLoZ4",
     *       "expiredAt": 1695351594
     *       }
     *   }
     * }
     */
    public function __invoke(LoginRequest $request, ApiLoginAction $loginAction)
    {
        try {

            $ptsUser = $loginAction->handle($request);

            return $this->sendSuccess(new LoginResponseResource($ptsUser));

        } catch (BadRequestException $e) {

            return $this->badRequest($e->getMessage());

        }
    }
}