<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\FieldPageService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Field Page
 * @sorting 3
 */
class ApiFieldPageController extends ApiController
{
    public function __construct(
        private FieldPageService $fieldPageService
    ) {
    }

    /**
     * User Case Field
     *
     * @authenticated
     * @defaultParam
     * @pathParam block_id string required
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
    public function userCaseField(Request $request, $block_id)
    {
        $data = $this->fieldPageService->userCaseField($block_id);
        return $this->sendSuccess($data);
    }

    /**
     * Field Summary Production
     *
     * @authenticated
     * @defaultParam
     * @pathParam block_id string required
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
    public function fieldSummaryProduction(Request $request, $block_id)
    {
        $data = $this->fieldPageService->fieldSummaryProduction($block_id);
        return $this->sendSuccess($data);
    }

    /**
     * Field Chart Gas
     *
     * @authenticated
     * @defaultParam
     * @pathParam block_id string required
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
    public function fieldChartGas(Request $request, $block_id, $filter = null)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->fieldPageService->fieldChartGas($block_id, $filter);
        } else {
            $data = $this->fieldPageService->fieldChartGas($block_id, $filter);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Field Chart Oil
     *
     * @authenticated
     * @defaultParam
     * @pathParam block_id string required
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
    public function fieldChartOil(Request $request, $block_id, $filter = null)
    {
        $filter = $request->input('filter');

        if ($filter === 'YTD' || $filter === '360daysago') {
            $data = $this->fieldPageService->fieldChartOil($block_id, $filter);
        } else {
            $data = $this->fieldPageService->fieldChartOil($block_id, $filter);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Field Data List
     *
     * @authenticated
     * @defaultParam
     * @pathParam block_id string required
     * 
     * @response {
     *     "status": 200,
     *     "message": "success",
     *     "data": [
     *       {
     *          "name": "Belanak - 1",
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
     *          "name": "Belanak - 4",
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
     *          "name": "Belanak - 5",
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
     *          "name": "Belanak - 8",
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
     *          "name": "Belanak - 11",
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
    public function fieldDataList(Request $request, $block_id)
    {
        $data = $this->fieldPageService->fieldDataList($block_id);
        return $this->sendSuccess($data);
    }
}
