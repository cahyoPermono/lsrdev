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
     * @queryParam filter Filter data by "YTD" for Year-to-Date and data by "360daysago" for will calculate dates that are 360 ​​days from now..
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
    public function mainChartGas(Request $request)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->mainPageService->mainChartGas($filter);
        } else {
            $data = $this->mainPageService->mainChartGas();
        }

        return $this->sendSuccess($data);
    }



    /**
     * Main Chart Oil
     *
     * @authenticated
     * @defaultParam
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
    public function mainChartOil(Request $request)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->mainPageService->mainChartOil($filter);
        } else {
            $data = $this->mainPageService->mainChartOil();
        }

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
     *          "name": "Corridor",
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
     *          "name": "Onshore",
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
     *          "name": "Offshore",
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
     *          "name": "NOA",
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
     *          "name": "International",
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
    public function mainDataList(Request $request)
    {
        $data = $this->mainPageService->mainDataList();
        return $this->sendSuccess($data);
    }
}
