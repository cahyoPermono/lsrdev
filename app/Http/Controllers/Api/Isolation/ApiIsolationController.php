<?php

namespace App\Http\Controllers\Api\Isolation;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\IsolationService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Isolation
 * @sorting 7
 */
class ApiIsolationController extends ApiController
{
    public function __construct(
        private IsolationService $isolationService
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
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "pid": "4239849328943289342",
     *       "ic_detail": "Test IC For issue",
     *       "location": "445 Kemmer Keys Suite 123\nDaughertyville, MI 45924"
     *   }
     * }
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
        return $this->sendMessage("Successfully isolated and verified !");
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
    public function verificator(Request $request,$ptsId){
        $result = $this->isolationService->findVerificator($ptsId);
        return $this->sendSuccess($result);
    }
}