<?php

namespace App\Http\Controllers\Api\Hse;

use App\Http\Controllers\Controller;
use App\Services\Hse\SafetyCardService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group HSE - Safety Card
 * @sorting 15
 */
class ApiUtitilySafetyCardController extends ApiController
{
    public function __construct(
        private SafetyCardService $safetyCardService
    ) {
    }
    /**
     * [1] SC : Risk Rank
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": {
     *       "en": [
     *       "Low",
     *       "Medium",
     *       "High"
     *       ],
     *       "id": [
     *       "Rendah",
     *       "Sedang",
     *       "Tinggi"
     *       ]
     *   }
     *   }
     */
    public function riskRank(Request $request)
    {
        $result = $this->safetyCardService->riskRank();
        return $this->sendMessage($result);
    }

    /**
     * [2] SC : Category
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": {
     *       "en": [
     *       "Occupational Safety",
     *       "Process Safety"
     *       ],
     *       "id": [
     *       "Occupational Safety",
     *       "Process Safety"
     *       ]
     *   }
     *   }
     */
    public function category(Request $request)
    {
        $result = $this->safetyCardService->category();
        return $this->sendMessage($result);
    }

    /**
     * [3] SC : Block Function
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": {
     *       "en": [
     *       "Bangkanai",
     *       "Block A"
     *       ],
     *       "id": [
     *       "Bangkanai",
     *       "Block A"
     *       ]
     *   }
     *   }
     */
    public function blockFunction(Request $request)
    {
        $result = $this->safetyCardService->blockFunction();
        return $this->sendMessage($result);
    }

    /**
     * [4] SC : Location
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": {
     *           "en": [
     *               {
     *                   "block_or_function": "Bangkanai",
     *                   "location": "Bangkanai"
     *               }
     *           ],
     *           "id": [
     *               {
     *                   "block_or_function": "Bangkanai",
     *                   "location": "Bangkanai"
     *               }
     *           ]
     *       }
     *   }
     */
    public function location(Request $request)
    {
        $result = $this->safetyCardService->location();
        return $this->sendMessage($result);
    }


    /**
     * [5] SC : Division
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": {
     *           "en": [
     *               "E&P FINANCIAL SERVICES",
     *               "SURFACE ENGINEERING OFFSHORE"
     *           ],
     *           "id": [
     *               "E&P FINANCIAL SERVICES",
     *               "SURFACE ENGINEERING OFFSHORE"
     *           ]
     *       }
     *   }
     */
    public function division(Request $request)
    {
        $result = $this->safetyCardService->division();
        return $this->sendMessage($result);
    }

    /**
     * [5] SC : Department
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": {
     *           "en": [
     *               {
     *                   "division": "E&P FINANCIAL SERVICES",
     *                   "department": "ACCOUNTING SERVICES - BUSINESS EXPENSES SETTLEMENT"
     *               }
     *           ],
     *           "id": [
     *               {
     *                   "division": "E&P FINANCIAL SERVICES",
     *                   "department": "ACCOUNTING SERVICES - BUSINESS EXPENSES SETTLEMENT"
     *               }
     *           ]
     *       }
     *   }
     */
    public function department(Request $request)
    {
        $result = $this->safetyCardService->department();
        return $this->sendMessage($result);
    }
}
