<?php
namespace App\Http\Controllers\Api\UseCase2;


use App\Http\Controllers\Controller;
use App\Services\MedcoApi\UseCase2CompanyService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;


/**
 * @group Use Case 2/Company [1]
 * @sorting 10
 */
class ApiUseCaseCompanyController extends ApiController
{
    public function __construct(
        private UseCase2CompanyService $useCase2CompanyService
    ) {
    }

    /**
     * Company Summary
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "total": {
     *       "net": 3174390,
     *       "gross": 6227591
     *       },
     *       "day_variance": {
     *       "net": {
     *           "delta": 9487313,
     *           "percent": 97
     *       },
     *       "gross": {
     *           "delta": 8957346,
     *           "percent": 68
     *       }
     *       },
     *       "ytd_production": {
     *       "net": 4111477,
     *       "gross": 7431566
     *       }
     *   }
     * }
     */
    public function summary(Request $request)
    {
        $items = $this->useCase2CompanyService->summary();
        return $this->sendSuccess($items);
    }


    /**
     * 
     * Company GAS Chart
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam filter[period] string optional default YTD, value in YTD or 360_DAYS
     * 
     * @response {
     *      "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "date": "2022-11",
     *               "date_label": "Nov 2022",
     *               "month": "Nov",
     *               "year": "2022",
     *               "items": [
     *                   {
     *                       "label": "Budget",
     *                       "slug": "budget",
     *                       "value": {
     *                           "net": 8707532,
     *                           "gross": 2706203
     *                       },
     *                       "percent": {
     *                           "net": 95,
     *                           "gross": 6
     *                       }
     *                   },
     *                   {
     *                       "label": "Actual",
     *                       "slug": "actual",
     *                       "value": {
     *                           "net": 7640856,
     *                           "gross": 4134228
     *                       },
     *                       "percent": {
     *                           "net": 11,
     *                           "gross": 14
     *                       }
     *                   },
     *                   {
     *                       "label": "Outlook",
     *                       "slug": "outlook",
     *                       "value": {
     *                           "net": 6026038,
     *                           "gross": 8794316
     *                       },
     *                       "percent": {
     *                           "net": 83,
     *                           "gross": 38
     *                       }
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     */
    public function gasChart(Request $request)
    {
        $items = $this->useCase2CompanyService->chart($request->get("filter", []), 'gas');
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Company OIL Chart
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam filter[period] string optional default YTD, value in YTD or 360_DAYS
     * 
     * @response {
     *      "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "date": "2022-11",
     *               "date_label": "Nov 2022",
     *               "month": "Nov",
     *               "year": "2022",
     *               "items": [
     *                   {
     *                       "label": "Budget",
     *                       "slug": "budget",
     *                       "value": {
     *                           "net": 8707532,
     *                           "gross": 2706203
     *                       },
     *                       "percent": {
     *                           "net": 95,
     *                           "gross": 6
     *                       }
     *                   },
     *                   {
     *                       "label": "Actual",
     *                       "slug": "actual",
     *                       "value": {
     *                           "net": 7640856,
     *                           "gross": 4134228
     *                       },
     *                       "percent": {
     *                           "net": 11,
     *                           "gross": 14
     *                       }
     *                   },
     *                   {
     *                       "label": "Outlook",
     *                       "slug": "outlook",
     *                       "value": {
     *                           "net": 6026038,
     *                           "gross": 8794316
     *                       },
     *                       "percent": {
     *                           "net": 83,
     *                           "gross": 38
     *                       }
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     */
    public function oilChart(Request $request)
    {
        $items = $this->useCase2CompanyService->chart($request->get("filter", []), 'oil');
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Company Production Data
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "code": "block-a",
     *               "name": "Block A",
     *               "gas": {
     *                   "net": {
     *                       "delta": 2530684,
     *                       "percent": 16
     *                   },
     *                   "gross": {
     *                       "delta": 7795148,
     *                       "percent": 8
     *                   }
     *               },
     *               "oil": {
     *                   "net": {
     *                       "delta": 8316901,
     *                       "percent": 34
     *                   },
     *                   "gross": {
     *                       "delta": 9801210,
     *                       "percent": 0
     *                   }
     *               }
     *           }
     *       ]
     * }
     * 
     */
    public function productionData(Request $request)
    {
        $items = $this->useCase2CompanyService->productionData();
        return $this->sendSuccess($items);
    }


    /**
     * 
     * Company Sales Data
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "code": "block-a",
     *               "name": "Block A",
     *               "gas": {
     *                   "net": {
     *                       "delta": 2530684,
     *                       "percent": 16
     *                   },
     *                   "gross": {
     *                       "delta": 7795148,
     *                       "percent": 8
     *                   }
     *               },
     *               "oil": {
     *                   "net": {
     *                       "delta": 8316901,
     *                       "percent": 34
     *                   },
     *                   "gross": {
     *                       "delta": 9801210,
     *                       "percent": 0
     *                   }
     *               }
     *           }
     *       ]
     * }
     */
    public function salesData(Request $request)
    {
        $items = $this->useCase2CompanyService->salesData();
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Company Production vs Budget Data
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "name": "Offshore",
     *       "gas": {
     *           "net": {
     *           "wpnb": {
     *               "delta": 2933.55
     *           },
     *           "apbn": {
     *               "delta": 2933.44
     *           },
     *           "budget": {
     *               "delta": -6502.72
     *           }
     *           }
     *       }
     *       },
     *       {
     *       "name": "NOA",
     *       "gas": {
     *
     *            "net": {
     *           "wpnb": {
     *               "delta": 95.43
     *           },
     *           "apbn": {
     *               "delta": 102.91
     *           },
     *           "budget": {
     *               "delta": -24.63
     *           }
     *           }
     *       }
     *       }
     *   ]
     *   }
     */
    public function productionVsBudgetData(Request $request)
    {
        $items = $this->useCase2CompanyService->productionVsBudgetData();
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Company YTD Production Breakdown
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response 
     * {
     * "status": 200,
     * "message": "success",
     * "data": [
     *     {
     *     "country_code": "INA",
     *     "gross": {
     *         "ytd_production": 679089.11,
     *         "budget": 675286.01,
     *         "delta": 3803.1,
     *         "percent": 0.56
     *     },
     *     "nett": {
     *         "ytd_production": 306049.01,
     *         "budget": 380518.77,
     *         "delta": -74469.75,
     *         "percent": -19.57
     *     }
     *     },
     *     {
     *     "country_code": "INT",
     *     "gross": {
     *         "ytd_production": 114599.61,
     *         "budget": 122288.05,
     *         "delta": -7688.42,
     *         "percent": -6.29
     *     },
     *     "nett": {
     *         "ytd_production": 44377.35,
     *         "budget": 46300.51,
     *         "delta": -1923.16,
     *         "percent": -4.15
     *     }
     *     }
     * ]
     * }
     */
    public function productionBreakdown(Request $request)
    {
        $items = $this->useCase2CompanyService->productionBreakdown();
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Company Quarterly Production Data
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "code": "block-a",
     *               "name": "Block A",
     *               "gas": {
     *                   "net": {
     *                       "delta": 2530684,
     *                       "percent": 16
     *                   },
     *                   "gross": {
     *                       "delta": 7795148,
     *                       "percent": 8
     *                   }
     *               },
     *               "oil": {
     *                   "net": {
     *                       "delta": 8316901,
     *                       "percent": 34
     *                   },
     *                   "gross": {
     *                       "delta": 9801210,
     *                       "percent": 0
     *                   }
     *               }
     *           }
     *       ]
     * }
     * 
     */
    public function quarterlyProductionData(Request $request)
    {
        $items = $this->useCase2CompanyService->quarterlyProductionData();
        return $this->sendSuccess($items);
    }
    
}


