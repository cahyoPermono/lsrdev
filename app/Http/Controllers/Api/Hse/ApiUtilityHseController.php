<?php

namespace App\Http\Controllers\Api\Hse;

use App\Http\Controllers\Controller;
use App\Services\Hse\HseUtilityService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group HSE
 */
class ApiUtilityHseController extends ApiController
{
    public function __construct(
        private HseUtilityService $hseUtilityService
    ) {
    }

    /**
     * HSE : Banner Slider
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "id": 1,
     *               "title": "",
     *               "url": "https://intranet.medcoenergi.com/sites/HSE/_layouts/15/DocIdRedir.aspx?ID=JQ3TCU7HXC2P-1371258258-1",
     *               "image": "base64stringfile"
     *           }
     *       ]
     *   }
     */
    public function slider(Request $request)
    {
        $result = $this->hseUtilityService->findAllSlider();
        return $this->sendSuccess($result);
    }


    /**
     * HSE : Popup Campaign
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": {
     *               "id": 1,
     *               "title": "",
     *               "url": "https://intranet.medcoenergi.com/sites/HSE/_layouts/15/DocIdRedir.aspx?ID=JQ3TCU7HXC2P-1371258258-1",
     *               "image": "base64stringfile"
     *           }
     *   }
     */
    public function popupCampaign(Request $request)
    {
        $result = $this->hseUtilityService->findFirstPopupCampaign();
        return $this->sendSuccess($result);
    }

    /**
     * HSE : Upcoming Event
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam limit optional default 2
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "id": 1,
     *       "title": "HSE Weekly Meeting ",
     *       "start_at": "2024-05-08 02:30:00",
     *       "end_at": "2024-05-08 04:00:00"
     *       },
     *       {
     *       "id": 2,
     *       "title": "Update During Weekend",
     *       "start_at": "2024-05-08 00:30:00",
     *       "end_at": "2024-05-08 02:00:00"
     *       }
     *   ]
     * }
     */
    public function upcomingEvent(Request $request)
    {
        $limit = $request->get('limit', 2);
        $date = date('Y-m-d');

        $result = $this->hseUtilityService->findAllTopUpcomingEvent($limit, $date);
        return $this->sendSuccess($result);
    }

    /**
     * HSE : List Calendar Event
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam start_at optional default start date of current month
     * @queryParam end_at optional default end date of current month
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "id": 1,
     *       "title": "HSE Weekly Meeting ",
     *       "start_at": "2024-05-08 02:30:00",
     *       "end_at": "2024-05-08 04:00:00"
     *       },
     *       {
     *       "id": 2,
     *       "title": "Update During Weekend",
     *       "start_at": "2024-05-08 00:30:00",
     *       "end_at": "2024-05-08 02:00:00"
     *       }
     *   ]
     * }
     */
    public function events(Request $request)
    {

        $startAt = $request->get('start_at', now()->startOfMonth()->format('Y-m-d'));
        $endAt = $request->get('end_at', now()->endOfMonth()->format('Y-m-d'));
        $result = $this->hseUtilityService->findAllEvent($startAt, $endAt);
        return $this->sendSuccess($result);
    }

    /**
     * HSE : Documents
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam limit optional default 20
     * @queryParam page optional default 1
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "name": "CHP002",
     *       "description": "Medical Emergency Response Plans",
     *       "start_at": "2024-05-07 00:00:00",
     *       "is_new": true
     *       },
     *       {
     *       "name": "CHP001",
     *       "description": "Fit to Work Practice",
     *       "start_at": "2024-04-03 00:00:00",
     *       "is_new": false
     *       }
     *   ]
     *   }
     */
    public function documents(Request $request)
    {
        $limit = $request->get('limit', 20);
        $result = $this->hseUtilityService->findAllDocument($limit);
        return $this->sendSuccess($result);
    }


    /**
     * HSE : Quizz
     * 
     * @authenticated
     * @defaultParam
     * 
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "id": 5,
     *       "title": "HSE Quiz - Earth Day 2024",
     *       "url": "https://bit.ly/HSE_Monthly_Meeting_April_2024",
     *       "file": "base64filestring"
     *   }
     *   }
     */
    public function quizz(Request $request)
    {
        $result = $this->hseUtilityService->findFirstQuizz();
        return $this->sendSuccess($result);
    }


    /**
     * HSE : Leasson Learned
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam limit optional default 10
     * @queryParam page optional default 1
     * 
     * @response {
     *      "status": 200,
     *      "message": "success",
     *      "data": [
     *          {
     *              "id": 4,
     *              "title": "Lost Work-Days Case (LWDC)",
     *              "description": "stringHTMLcontent",
     *              "file": "base64filestring",
     *              "incident_time": "2024-01-08 00:00:00",
     *              "risk_ranking": "",
     *              "incident_location": "Onshore Asset â€“ DRECO Rig at Matra 2023 ",
     *              "leason_learned": "stringHTMLcontent",
     *              "asset_action": "stringHTMLcontent"
     *          }
     *      ]
     *  }
     */
    public function leassonLearned(Request $request)
    {
        $limit = $request->get('limit', 10);
        $result = $this->hseUtilityService->findAllLeassonLearned($limit);
        return $this->sendSuccess($result);
    }

    /**
     * HSE : Safety Poster
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam limit optional default 10
     * @queryParam page optional default 1
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "id": 8,
     *               "title": "",
     *               "author": "Ramzi Nilwarman Limboro",
     *               "file": "base64filestring"
     *           }
     *       ]
     * }
     */
    public function safetyPoster(Request $request)
    {
        $limit = $request->get('limit', 10);
        $result = $this->hseUtilityService->findAllSafetyPoster($limit);
        return $this->sendSuccess($result);
    }

     /**
     * HSE : News
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam limit optional default 10
     * @queryParam page optional default 1
     * 
     * @response {
     *      "status": 200,
     *      "message": "success",
     *      "data": [
     *          {
     *              "id": 2,
     *              "title_en": "SKK Migas Audit \"Siap Selamat\" & Safety Culture Maturity Assessment",
     *              "title_id": "",
     *              "file": "base64filestring",
     *              "contributor": "Astrid Astari",
     *              "date": "2024-04-03 17:00:00",
     *              "content_en": "stringHTMLcontent",
     *              "content_id": "stringHTMLcontent"
     *          }
     *      ]
     *  }
     */
    public function news(Request $request)
    {
        $limit = $request->get('limit', 10);
        $result = $this->hseUtilityService->findAllNews($limit);
        return $this->sendSuccess($result);
    }
}
