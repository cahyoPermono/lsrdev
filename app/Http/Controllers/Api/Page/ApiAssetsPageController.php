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
     * @pathParam main_id string required
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *          "value": {
     *              "net": 748888,
     *              "gross": 693953
     *          },
     *          "values": {
     *              "net": -1,
     *              "gross": 1
     *          },
     *          "title": "MEDC.",
     *          "date": "2023-08-24"
     *       },
     *       {
     *          "value": {
     *              "net": 931947,
     *              "gross": 817878
     *          },
     *          "values": {
     *              "net": -1,
     *              "gross": 1
     *          },
     *          "title": "Brent",
     *          "date": "2023-08-24"
     *       },
     *       {
     *          "value": {
     *              "net": 872194,
     *              "gross": 882703
     *          },
     *          "values": {
     *              "net": -1,
     *              "gross": -1
     *          },
     *          "title": "CPI",
     *          "date": "2023-08-24"
     *       }
     *     ]
     * }
     */
    public function userCaseAssets(Request $request, $main_id)
    {
        $data = $this->assetsPageService->userCaseAssets($main_id);
        return $this->sendSuccess($data);
    }

    /**
     * Assets Summary Production
     *
     * @authenticated
     * @defaultParam
     * @pathParam main_id string required
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
     *           {
     *             "title": "Day Variance",
     *             "value": {
     *                 "net": 553271,
     *                 "gross": 772923
     *              },
     *              "values": {
     *                  "net": -1,
     *                  "gross": -1
     *              }
     *           },
     *           {
     *              "title": "YTD Production",
     *              "value": {
     *                  "net": 553271,
     *                  "gross": 772923
     *               },
     *               "values": {
     *                  "net": -1,
     *                  "gross": 1
     *               }
     *            }
     *         ]
     *     }
     * }
     */
    public function assetsSummaryProduction(Request $request, $main_id)
    {
        $data = $this->assetsPageService->assetsSummaryProduction($main_id);
        return $this->sendSuccess($data);
    }

    /**
     * Assets Chart Gas
     *
     * @authenticated
     * @defaultParam
     * @pathParam main_id string required
     * @queryParam filter Filter data by "YTD" for Year-to-Date and data by "360daysago" for will calculate dates that are 360 ​​days from now.
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *         {
     *             "month": "October",
     *             "items": [
     *                 {
     *                     "title": "Budget",
     *                     "value": {
     *                         "net": 12345,
     *                         "gross": 67890
     *                     },
     *                     "slug": "budget",
     *                     "code": "1"
     *                 },
     *                 {
     *                     "title": "Actual",
     *                     "value": {
     *                         "net": 12345,
     *                         "gross": 67890
     *                     },
     *                     "slug": "actual",
     *                     "code": "2"
     *                 },
     *                 {
     *                     "title": "Outlook",
     *                     "value": {
     *                         "net": 12345,
     *                         "gross": 67890
     *                     },
     *                     "slug": "outlook",
     *                     "code": "3"
     *                 }
     *             ]
     *         }
     *     ]
     * }
     */
    public function assetsChartGas(Request $request, $main_id, $filter = null)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->assetsPageService->assetsChartGas($main_id, $filter);
        } else {
            $data = $this->assetsPageService->assetsChartGas($main_id, $filter);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Assets Chart Oil
     *
     * @authenticated
     * @defaultParam
     * @pathParam main_id string required
     * @queryParam filter Filter data by "YTD" for Year-to-Date and data by "360daysago" for will calculate dates that are 360 ​​days from now.
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "month": "October",
     *          "items": [
     *           {
     *              "title": "Budget",
     *              "value": {
     *                  "net": 12345,
     *                  "gross": 54321
     *              },
     *              "slug": "budget",
     *              "code": "1"      
     *           },
     *           {
     *              "title": "Actual",
     *              "value": {
     *                  "net": 12345,
     *                  "gross": 54321
     *              },
     *              "slug": "actual",
     *              "code": "2"   
     *           },
     *           {
     *              "title": "Outlook",
     *              "value": {
     *                  "net": 12345,
     *                  "gross": 54321
     *              },
     *              "slug": "outlook",
     *              "code": "3"   
     *           }
     *           ]
     *        }
     *     ]
     * }
     */
    public function assetsChartOil(Request $request, $main_id, $filter = null)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->assetsPageService->assetsChartOil($main_id, $filter);
        } else {
            $data = $this->assetsPageService->assetsChartOil($main_id, $filter);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Assets Data List
     *
     * @authenticated
     * @defaultParam
     * @pathParam main_id string required
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "name": "Block A",
     *          "gas": {
     *             "value": {
     *                "net": 531657,
     *                "gross": 879206
     *              },
     *              "values": {
     *                 "net": -1,
     *                 "gross": 1
     *              }
     *           },
     *           "oil": {
     *             "value": {
     *                  "net": 560563,
     *                  "gross": 621935
     *               },
     *              "values": {
     *                   "net": -1,
     *                   "gross": -1
     *                }
     *             }
     *        },
     *       {
     *          "name": "Dayung",
     *          "gas": {
     *             "value": {
     *                "net": 688120,
     *                "gross": 688924
     *              },
     *              "values": {
     *                 "net": -1,
     *                 "gross": 1
     *              }
     *           },
     *           "oil": {
     *             "value": {
     *                  "net": 719694,
     *                  "gross": 974323
     *               },
     *              "values": {
     *                   "net": 1,
     *                   "gross": -1
     *                }
     *             }
     *         },
     *       {
     *          "name": "Sumpal",
     *          "gas": {
     *             "value": {
     *                "net": 789175,
     *                "gross": 531051
     *              },
     *              "values": {
     *                 "net": 1,
     *                 "gross": 1
     *              }
     *           },
     *           "oil": {
     *             "value": {
     *                  "net": 790571,
     *                  "gross": 517321
     *               },
     *              "values": {
     *                   "net": -1,
     *                   "gross": -1
     *                }
     *             }
     *         },
     *       {
     *          "name": "Rawa Letang",
     *          "gas": {
     *             "value": {
     *                "net": 689997,
     *                "gross": 990043
     *              },
     *              "values": {
     *                 "net": 1,
     *                 "gross": -1
     *              }
     *           },
     *           "oil": {
     *             "value": {
     *                  "net": 917904,
     *                  "gross": 987581
     *               },
     *              "values": {
     *                   "net": 1,
     *                   "gross": 1
     *                }
     *             }
     *         },
     *       {
     *          "name": "Gelam",
     *          "gas": {
     *             "value": {
     *                "net": 616501,
     *                "gross": 560264
     *              },
     *              "values": {
     *                 "net": 1,
     *                 "gross": -1
     *              }
     *           },
     *           "oil": {
     *             "value": {
     *                  "net": 786467,
     *                  "gross": 778249
     *               },
     *              "values": {
     *                   "net": 1,
     *                   "gross": -1
     *                }
     *             }
     *         }
     *     ]
     * }
     */
    public function assetsDataList(Request $request, $main_id)
    {
        $data = $this->assetsPageService->assetsDataList($main_id);
        return $this->sendSuccess($data);
    }
}
