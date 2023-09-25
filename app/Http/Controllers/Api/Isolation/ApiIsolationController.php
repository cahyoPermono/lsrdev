<?php

namespace App\Http\Controllers\Api\Isolation;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\IsolationService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Isolation
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
     *       "verified_by": "Oscar Aufderhar"
     *       },
     *       {
     *       "id": "ID-N-CG-MU-23-23DE566",
     *       "code": "ID-N-CG-MU-23-23DE566",
     *       "is_done": false,
     *       "ip": "I00004",
     *       "required": "CLO",
     *       "lock": 5,
     *       "is_isolated": false,
     *       "verified_by": null
     *       }
     *   ]
     * }
     */
    public function method(Request $request, $pid, $type)
    {
        $method = str_replace(' ', '', ucwords(str_replace("-", " ", $type)));
        $function = "findIsolation{$method}";
        $items = $this->isolationService->{$function}($pid);
        return $this->sendSuccess($items);
    }

    /**
     * Update Method
     */
    public function updateMethod(Request $request, $pid)
    {

    }
}