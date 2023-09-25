<?php

namespace App\Http\Controllers\Api\SelfScreening;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\SelfScreeningService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Self Screening
 */
class ApiSelfScreeningController extends ApiController
{
    public function __construct(
        private SelfScreeningService $selfScreeningService
    ) {
    }
    /**
     * Certificate List
     * 
     * <b>CODE LIST</b>
     * <code>
     *  MEDICAL CHECK UP = 2-MCU
     *  HSE ORIENTATION = 1-HSEORI
     *  COVID = COVID
     * </code>
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "name": "2 Medic.Check Up",
     *       "valid_until": "2023-08-09",
     *       "code": "2-MCU",
     *       "items": []
     *       },
     *       {
     *       "name": "1 HSE Orientatio",
     *       "valid_until": "2023-09-05",
     *       "code": "1-HSEORI",
     *       "items": []
     *       },
     *       {
     *       "name": "Covid Vaccine",
     *       "valid_until": null,
     *       "code": "COVID",
     *       "items": [
     *           {
     *           "name": "2 Covid19 Vacc 1",
     *           "valid_until": "2099-12-31",
     *           "code": "2-COVID1"
     *           },
     *           {
     *           "name": "2 Covid19 Vacc 2",
     *           "valid_until": "2099-12-31",
     *           "code": "2-COVID2"
     *           },
     *           {
     *           "name": "2 Covid19 Vacc 3",
     *           "valid_until": "2099-12-31",
     *           "code": "2-COVID3"
     *           }
     *       ]
     *       }
     *   ]
     * }
     */
    public function certificate(Request $request)
    {
        $person_id = $this->auth()->person_id;
        $items = $this->selfScreeningService->certificate($person_id);
        return $this->sendSuccess($items);
    }

    /**
     * 
     * PTS Certificate
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "name": "2 Cont Period",
     *       "valid_until": "2023-12-31",
     *       "issue_date": "2022-01-20",
     *       "registered_date": "2019-09-02",
     *       "changed_date": "2023-09-15",
     *       "code": "2-CP",
     *       "type": "Site Specific",
     *       "clinic_doctor": null
     *       }
     *   ]
     * }
     * 
     */
    public function ptsCertificate(Request $request)
    {
        $person_id = $this->auth()->person_id;
        $items = $this->selfScreeningService->ptsCertificate($person_id);
        return $this->sendSuccess($items);
    }
}