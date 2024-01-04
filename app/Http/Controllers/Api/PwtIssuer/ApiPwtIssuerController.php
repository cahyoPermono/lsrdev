<?php

namespace App\Http\Controllers\Api\PwtIssuer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\MedcoApi\PWTIssuerService;
use App\Actions\PWTIssuer\SubmitUpdateWLAction;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

/**
 * @group PWT Issuer
 * @sorting 8
 */
class ApiPwtIssuerController extends ApiController
{
    public function __construct(
        private PWTIssuerService $pwtIssuerService
    ) {
    }
    /**
     * Detail PWT Issuer
     * 
     * Available status
     * <code>'Printed', 'Issued', 'Activated', 'Close', 'On-Hold', 'Waiting Re-Issue'</code>
     * 
     * @authenticated
     * @defaultParam
     * @pathParam pid string required
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "pid": "323232",
     *       "wp_number": "10-2023-Sep-26",
     *       "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua",
     *       "job_location": "8682 Adela Station\nHintzfort, NV 35197",
     *       "status": "Waiting Re-Issue"
     *   }
     * }
     */
    public function index(Request $request, $pid)
    {
        $items = $this->pwtIssuerService->findByPid($pid);
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Detail WL
     * 
     * @authenticated
     * @defaultParam
     * @pathParam pid string required
     * @pathParam code string required
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "date": "2023-09-26",
     *       "image": "https://laz-img-cdn.alicdn.com/images/ims-web/TB1LLFTsljTBKNjSZFuXXb0HFXa.jpg_1200x1200.jpg",
     *       "items": [
     *       {
     *           "permit_wan": 3497,
     *           "status": "Activated"
     *       }
     *       ]
     *   }
     * }
     */
    public function wlList(Request $request, $pid, $code)
    {
        $items = $this->pwtIssuerService->findAllWLByPidAndCode($pid, $code);
        return $this->sendSuccess($items);
    }

    /**
     * Update WL
     * 
     * @authenticated
     * @defaultParam
     * @pathParam pid string required
     * @pathParam code string optional
     * 
     * @requestBody application/x-www-form-urlencoded
     * @bodyParam status string required
     * 
     * @response {
     *   "status": 200,
     *   "message": "Update Status 'Issued' has Successfully saved"
     * }
     */
    public function updateWl(Request $request, SubmitUpdateWLAction $submitUpdateWLAction, $pid, $code)
    {
        try {
            $status = $request->get('status');
            $person_id = $this->auth()->person_id;
            $submitUpdateWLAction->handle($request, $person_id, $pid, $code);

            return $this->sendMessage("Update Status '{$status}' has Successfully saved");
        } catch (BadRequestException $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}