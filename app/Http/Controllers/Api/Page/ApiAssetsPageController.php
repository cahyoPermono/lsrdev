<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\AssetsPageService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Assets Page
 * @sorting 3
 */
class ApiAssetsPageController extends ApiController
{
    public function __construct(
        private AssetsPageService $assetsPageService
    ) {
    }

    /**
     * User Case Assets
     *
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *          "title": "MEDC.",
     *          "date": "2023-08-24",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        },
     *       {
     *          "title": "Brent",
     *          "date": "2023-08-24",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        },
     *       {
     *          "title": "CPI",
     *          "date": "2023-08-24",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        }
     *     ]
     * }
     */
    public function userCaseMain(Request $request, $main_id)
    {
        $data = $this->assetsPageService->userCaseMain($main_id);
        return $this->sendSuccess($data);
    }

    /**
     * Assets Summary Production
     *
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": {
     *         "total_value": {
     *             "net": 12345,
     *             "gross": 67890
     *         },
     *         "items": [
     *             {
     *                 "title": "Day Variance",
     *                 "value": {
     *                     "net": 54321,
     *                     "gross": 98765
     *                 }
     *             },
     *             {
     *                 "title": "YTD Production",
     *                 "value": {
     *                     "net": 67890,
     *                     "gross": 12345
     *                 }
     *             }
     *         ]
     *     }
     * }
     */
    public function assetsSummaryProduction(Request $request)
    {
        $data = $this->assetsPageService->assetsSummaryProduction();
        return $this->sendSuccess($data);
    }

    /**
     * Assets Chart Gas
     *
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "month": "October",
     *          "title": "Budget",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        },
     *       {
     *          "month": "November",
     *          "title": "Actual",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        },
     *       {
     *          "month": "December",
     *          "title": "Outlook",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        }
     *     ]
     * }
     */
    public function assetsChartGas(Request $request)
    {
        $data = $this->assetsPageService->assetsChartGas();
        return $this->sendSuccess($data);
    }

    /**
     * Assets Chart Oil
     *
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "month": "October",
     *          "title": "Budget",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        },
     *       {
     *          "month": "November",
     *          "title": "Actual",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        },
     *       {
     *          "month": "December",
     *          "title": "Outlook",
     *          "value": {
     *              "net": 12345,
     *              "gross": 67890
     *           }
     *        }
     *     ]
     * }
     */
    public function assetsChartOil(Request $request)
    {
        $data = $this->assetsPageService->assetsChartOil();
        return $this->sendSuccess($data);
    }

    /**
     * Assets Data List
     *
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "production": "Block A",
     *          "mmscfd": {
     *              "net": 12345,
     *              "gross": 67890
     *           },
     *          "bpopd": {
     *              "net": 12345,
     *              "gross": 67890
     *            }
     *        },
     *       {
     *          "production": "Dayung",
     *          "mmscfd": {
     *              "net": 12345,
     *              "gross": 67890
     *           },
     *          "bpopd": {
     *              "net": 12345,
     *              "gross": 67890
     *            }
     *        },
     *       {
     *          "production": "Sumpal",
     *          "mmscfd": {
     *              "net": 12345,
     *              "gross": 67890
     *           },
     *          "bpopd": {
     *              "net": 12345,
     *              "gross": 67890
     *            }
     *        },
     *       {
     *          "production": "Rawa Letang",
     *          "mmscfd": {
     *              "net": 12345,
     *              "gross": 67890
     *           },
     *          "bpopd": {
     *              "net": 12345,
     *              "gross": 67890
     *            }
     *        },
     *       {
     *          "production": "Gelam",
     *          "mmscfd": {
     *              "net": 12345,
     *              "gross": 67890
     *           },
     *          "bpopd": {
     *              "net": 12345,
     *              "gross": 67890
     *            }
     *        }
     *     ]
     * }
     */
    public function assetsDataList(Request $request)
    {
        $data = $this->assetsPageService->assetsDataList();
        return $this->sendSuccess($data);
    }
}
