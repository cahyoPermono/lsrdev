<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\BlockPageService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Block Page
 * @sorting 3
 */
class ApiBlockPageController extends ApiController
{
    public function __construct(
        private BlockPageService $blockPageService
    ) {
    }

    /**
     * User Case Block
     *
     * @authenticated
     * @defaultParam
     * @pathParam assets_id string required
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
    public function userCaseBlock(Request $request, $assets_id)
    {
        $data = $this->blockPageService->userCaseBlock($assets_id);
        return $this->sendSuccess($data);
    }

    /**
     * Block Summary Production
     *
     * @authenticated
     * @defaultParam
     * @pathParam assets_id string required
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
    public function blockSummaryProduction(Request $request, $assets_id)
    {
        $data = $this->blockPageService->blockSummaryProduction($assets_id);
        return $this->sendSuccess($data);
    }

    /**
     * Block Chart Gas
     *
     * @authenticated
     * @defaultParam
     * @pathParam assets_id string required
     * @queryParam filter Filter data by "YTD" for Year-to-Date and data by "360daysago" for will calculate dates that are 360 ​​days from now.
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *         {
     *             "month": "November",
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
    public function blockChartGas(Request $request, $assets_id, $filter = null)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->blockPageService->blockChartGas($assets_id, $filter);
        } else {
            $data = $this->blockPageService->blockChartGas($assets_id, $filter);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Block Chart Oil
     *
     * @authenticated
     * @defaultParam
     * @pathParam assets_id string required
     * @queryParam filter Filter data by "YTD" for Year-to-Date and data by "360daysago" for will calculate dates that are 360 ​​days from now.
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "month": "November",
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
    public function blockChartOil(Request $request, $assets_id, $filter = null)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->blockPageService->blockChartOil($assets_id, $filter);
        } else {
            $data = $this->blockPageService->blockChartOil($assets_id, $filter);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Block Data List
     *
     * @authenticated
     * @defaultParam
     * @pathParam assets_id string required
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "name": "Belanak",
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
     *          "name": "North Belut",
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
     *          "name": "Kerisi",
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
     *          "name": "Hang Tuah",
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
     *          "name": "Belida",
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
    public function blockDataList(Request $request, $assets_id)
    {
        $data = $this->blockPageService->blockDataList($assets_id);
        return $this->sendSuccess($data);
    }
}
