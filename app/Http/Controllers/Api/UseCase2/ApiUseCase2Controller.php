<?php

namespace App\Http\Controllers\Api\UseCase2;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\UseCase2Service;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;


/**
 * @group Use Case 2
 * @sorting 9
 */
class ApiUseCase2Controller extends ApiController
{
    public function __construct(
        private UseCase2Service $useCase2Service
    ){}
    /**
     * Summary : (TOP OF SCREEN)
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "title": "MEDCO",
     *       "date": "2023-11-09",
     *       "value": 729167,
     *       "delta": -2,
     *       "percent": -4
     *       },
     *       {
     *       "title": "Brent",
     *       "date": "2023-11-09",
     *       "value": 248536,
     *       "delta": 1,
     *       "percent": -1
     *       },
     *       {
     *       "title": "CPI",
     *       "date": "2023-11-09",
     *       "value": 455629,
     *       "delta": -5,
     *       "percent": -5
     *       }
     *   ]
     * }
     * 
     */
    public function index(Request $request)
    {
        $items = $this->useCase2Service->summaryStockPrice();
        return $this->sendSuccess($items);
    }
}
