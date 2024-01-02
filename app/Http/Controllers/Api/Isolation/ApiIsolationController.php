<?php

namespace App\Http\Controllers\Api\Isolation;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\IsolationService;
use App\Services\MedcoApi\MedcoUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

/**
 * @group Isolation
 * @sorting 7
 */
class ApiIsolationController extends ApiController
{
    public function __construct(
        private IsolationService $isolationService,
        private MedcoUserService $medcoUserService
    ) {
    }

    /**
     * Detail Isolation
     * 
     * @authenticated
     * @defaultParam
     * @pathParam pid string required
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": {
     *           "pid": 3503942,
     *           "ic_detail": "Normal Shutdown RGC 24-CAE-101 & 24-CAE-201 (standby mode)",
     *           "location": "Grissik Plant - Regen Gas Compressor",
     *           "ic_no" : "IC0000000174",
     *           "ic_status" : "Non-Positive Isolation and Verification",
     *           "details": [
     *               {
     *                   "name": "Electrical Isolation",
     *                   "items": [
     *                       {
     *                           "id": "I00001",
     *                           "code": "ID-N-CG-MU-23-23DE506",
     *                           "name": "MAIN BREAKER MOTOR RGC 1",
     *                           "is_done": false,
     *                           "ip": "I00001",
     *                           "required": "BLO - Breaker Lock Out",
     *                           "lock": "2",
     *                           "is_isolated": false,
     *                           "verified_by": null,
     *                           "status" : "Done",
     *                           "isolator" : "Mahfud"
     *                       }
     *                   ]
     *               }
     *           ]
     *       }
     *   }
     */
    public function index(Request $request, $pid)
    {
        $result = $this->isolationService->findByPid($pid);
        return $this->sendSuccess($result);
    }

    /**
     * Isolation Method list
     * 
     * @authenticated
     * @defaultParam
     * @pathParam pid string required
     * @pathParam type string required in <code>'process', 'automation', 'electrical', 'esd', 'positive'</code>
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "id": "ID-N-CG-MU-23-23DE333",
     *       "code": "ID-N-CG-MU-23-23DE333",
     *       "is_done": true,
     *       "ip": "I00009",
     *       "required": "CLO",
     *       "lock": 9,
     *       "is_isolated": true,
     *       "verified_by": "Oscar Aufderhar",
     *       "name": "Oscar"
     *       },
     *       {
     *       "id": "ID-N-CG-MU-23-23DE566",
     *       "code": "ID-N-CG-MU-23-23DE566",
     *       "is_done": false,
     *       "ip": "I00004",
     *       "required": "CLO",
     *       "lock": 5,
     *       "is_isolated": false,
     *       "verified_by": null,
     *       "name": "Oscar"
     *       }
     *   ]
     * }
     */
    public function method(Request $request, $pid, $type)
    {
        // $method = str_replace(' ', '', ucwords(str_replace("-", " ", $type)));
        // $function = "findIsolation{$method}";
        // $items = $this->isolationService->{$function}($pid);
        return $this->sendSuccess([]);
    }

    /**
     * Update Method
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody application/x-www-form-urlencoded
     * @bodyParam isolated_id string required
     * @bodyParam ip_number string required
     * @bodyParam is_isolated boolean required
     * @bodyParam verifier_name string required
     * @bodyParam verifier_id string required person id
     * 
     * @response {
     *   "status": 200,
     *   "message": "Successfully isolated and verified !"
     *  }
     */
    public function updateMethod(Request $request, $pid)
    {
        try {
            $this->validates([
                'ip_number' => 'required',
                'verifier_name' => 'required',
                'verifier_id' => 'required',
            ]);

            $user = $this->auth();

            $result = $this->isolationService->postUpdateIsolation(
                pid: $pid,
                ipNumber: $request->ip_number,
                userPtsId: $user->person_id,
                userPtsName: $user->name,
                verificatorId: $request->verifier_id,
                verificatorName: $request->verifier_name
            );
            $statusCode = @$result['status_code'] ?: @$result['status'];
            if(in_array($statusCode,[Response::HTTP_OK,Response::HTTP_CREATED])){
                return $this->sendMessage("Successfully isolated and verified !");
            }else{
                return $this->badRequest(@$result['message']);
            }
        } catch (BadRequestException $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * Find Verificator
     * 
     * @authenticated
     * @defaultParam
     * @pathParam ptsid string required
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "pts_id": "4239849328943289342",
     *       "name": "Test IC For issue",
     *       "validity": "445 Kemmer Keys Suite 123\nDaughertyville, MI 45924",
     *       "role_verificator": "445 Kemmer Keys Suite 123\nDaughertyville, MI 45924"
     *   }
     * }
     */
    public function verificator(Request $request, $ptsId)
    {
        $result = $this->isolationService->findVerificator($ptsId);
        return $this->sendSuccess($result);
    }
}