<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\MainPageService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Main Page
 * @sorting 3
 */
class ApiMainPageController extends ApiController
{
    public function __construct(
        private MainPageService $mainPageService
    ) {
    }

    /**
     * User Case Main
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
    public function userCaseMain(Request $request)
    {
        $data = $this->mainPageService->userCaseMain();
        return $this->sendSuccess($data);
    }

    /**
     * Main Summary Production
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
    public function mainSummaryProduction(Request $request)
    {
        $data = $this->mainPageService->mainSummaryProduction();
        return $this->sendSuccess($data);
    }

    /**
     * Main Chart Gas
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
    public function mainChartGas(Request $request)
    {
        $data = $this->mainPageService->mainChartGas();
        return $this->sendSuccess($data);
    }

    /**
     * Main Chart Oil
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
    public function mainChartOil(Request $request)
    {
        $data = $this->mainPageService->mainChartOil();
        return $this->sendSuccess($data);
    }

    /**
     * Main Data List
     *
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "production": "Corridor",
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
     *          "production": "Onshore",
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
     *          "production": "Offshore",
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
     *          "production": "Noa",
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
     *          "production": "International",
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
    public function mainDataList(Request $request)
    {
        $data = $this->mainPageService->mainDataList();
        return $this->sendSuccess($data);
    }
}
