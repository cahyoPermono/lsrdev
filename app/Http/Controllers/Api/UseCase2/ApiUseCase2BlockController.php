<?php
namespace App\Http\Controllers\Api\UseCase2;


use App\Services\MedcoApi\UseCase2BlockService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Use Case 2/Block [3]
 * @sorting 12
 */
class ApiUseCase2BlockController extends ApiController
{
    public function __construct(
        private UseCase2BlockService $useCase2BlockService
    ) {
    }

    /**
     * Block Summary
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam code string required
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
    public function summary(Request $request, $code)
    {
        $items = $this->useCase2BlockService->summary($code);
        return $this->sendSuccess($items);
    }


    /**
     * 
     * Block GAS Chart
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam code string required
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
    public function gasChart(Request $request, $code)
    {
        $items = $this->useCase2BlockService->gasChart($code, $request->get("filter", []));
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Block OIL Chart
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam code string required
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
    public function oilChart(Request $request, $code)
    {
        $items = $this->useCase2BlockService->oilChart($code, $request->get("filter", []));
        return $this->sendSuccess($items);
    }

    /**
     * 
     * Block Production Data
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam code string required
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
    public function productionData(Request $request, $code)
    {
        $items = $this->useCase2BlockService->productionData($code);
        return $this->sendSuccess($items);
    }


    /**
     * 
     * Block Sales Data
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam code string required  
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
    public function salesData(Request $request, $code)
    {
        $items = $this->useCase2BlockService->salesData($code);
        return $this->sendSuccess($items);
    }
}
