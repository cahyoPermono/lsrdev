<?php

namespace App\Http\Controllers\Api\Hse;

use App\Actions\Hse\SubmitHseSafetyCardAction;
use App\Http\Controllers\Controller;
use App\Services\Hse\SafetyCardService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group HSE - Safety Card
 * @sorting 15
 */
class ApiUtitilySafetyCardController extends ApiController
{
    public function __construct(
        private SafetyCardService $safetyCardService
    ) {
    }

     /**
     * [17] SC : List Safety Card
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "id": 11367,
     *               "report_type": "Perilaku Aman",
     *               "block_or_function": "Bangkanai",
     *               "location": "Bangkanai",
     *               "date": "20 May 2024",
     *               "brief_desc": "-"
     *           }
     *       ]
     *   }
     */
    public function index(Request $request){
        $result = $this->safetyCardService->list($this->auth()->email);
        return $this->sendSuccess($result);
    }
    /**
     * [16] SC : Statistic
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "today": 0,
     *       "this_week": 9,
     *       "this_month": 9,
     *       "this_year": 26,
     *       "overall": 0
     *   }
     *   }
     */
    public function statistic(Request $request){
        $result = $this->safetyCardService->statistic($this->auth()->email);
        return $this->sendSuccess($result);
    }
    /**
     * [1] SC : Risk Rank
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "data": {
     *       "en": [
     *       "Low",
     *       "Medium",
     *       "High"
     *       ],
     *       "id": [
     *       "Rendah",
     *       "Sedang",
     *       "Tinggi"
     *       ]
     *   }
     *   }
     */
    public function riskRank(Request $request)
    {
        $result = $this->safetyCardService->riskRank();
        return $this->sendSuccess($result);
    }

    /**
     * [2] SC : Category
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "data": {
     *       "en": [
     *       "Occupational Safety",
     *       "Process Safety"
     *       ],
     *       "id": [
     *       "Occupational Safety",
     *       "Process Safety"
     *       ]
     *   }
     *   }
     */
    public function category(Request $request)
    {
        $result = $this->safetyCardService->category();
        return $this->sendSuccess($result);
    }

    /**
     * [3] SC : Block Function
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "data": {
     *       "en": [
     *       "Bangkanai",
     *       "Block A"
     *       ],
     *       "id": [
     *       "Bangkanai",
     *       "Block A"
     *       ]
     *   }
     *   }
     */
    public function blockFunction(Request $request)
    {
        $result = $this->safetyCardService->blockFunction();
        return $this->sendSuccess($result);
    }

    /**
     * [4] SC : Location
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               {
     *                   "block_or_function": "Bangkanai",
     *                   "location": "Bangkanai"
     *               }
     *           ],
     *           "id": [
     *               {
     *                   "block_or_function": "Bangkanai",
     *                   "location": "Bangkanai"
     *               }
     *           ]
     *       }
     *   }
     */
    public function location(Request $request)
    {
        $result = $this->safetyCardService->location();
        return $this->sendSuccess($result);
    }


    /**
     * [5] SC : Division
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "E&P FINANCIAL SERVICES",
     *               "SURFACE ENGINEERING OFFSHORE"
     *           ],
     *           "id": [
     *               "E&P FINANCIAL SERVICES",
     *               "SURFACE ENGINEERING OFFSHORE"
     *           ]
     *       }
     *   }
     */
    public function division(Request $request)
    {
        $result = $this->safetyCardService->division();
        return $this->sendSuccess($result);
    }

    /**
     * [5] SC : Department
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               {
     *                   "division": "E&P FINANCIAL SERVICES",
     *                   "department": "ACCOUNTING SERVICES - BUSINESS EXPENSES SETTLEMENT"
     *               }
     *           ],
     *           "id": [
     *               {
     *                   "division": "E&P FINANCIAL SERVICES",
     *                   "department": "ACCOUNTING SERVICES - BUSINESS EXPENSES SETTLEMENT"
     *               }
     *           ]
     *       }
     *   }
     */
    public function department(Request $request)
    {
        $result = $this->safetyCardService->department();
        return $this->sendSuccess($result);
    }


    /**
     * [6] SC : Report Type
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "data": {
     *       "en": [
     *       "1.1 Safe Behaviour",
     *       "1.2 Unsafe Behaviour"
     *       ],
     *       "id": [
     *       "1.1 Perilaku Aman",
     *       "1.2 Perilaku Tidak Aman"
     *       ]
     *   }
     *   }
     */
    public function reportType(Request $request)
    {
        $result = $this->safetyCardService->reportType();
        return $this->sendSuccess($result);
    }

    /**
     * [7] SC : Positibily Of Event
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "2.1 Struck against/by",
     *               "2.2 Fall/Trapped"
     *           ],
     *           "id": [
     *               "2.1 Menabrak / Tertabrak",
     *               "2.2 Terjatuh / Terperangkap"
     *           ]
     *       }
     *   }
     */
    public function positibilyOfEvent(Request $request)
    {
        $result = $this->safetyCardService->positibilyOfEvent();
        return $this->sendSuccess($result);
    }

    /**
     * [8] SC : Unsafe Behaviour
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "3.1.1 Operating Equipment without Authority",
     *               "3.1.2 Failure to Secure / Warn"
     *           ],
     *           "id": [
     *               "3.1.1 Mengoperasikan Tanpa Izin",
     *               "3.1.2 Gagal Mengingatkan / Mengamankan"
     *           ]
     *       }
     *   }
     */
    public function unsafeBehaviour(Request $request)
    {
        $result = $this->safetyCardService->unsafeBehaviour();
        return $this->sendSuccess($result);
    }

    /**
     * [9] SC : Unsafe Condition
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "3.2.1 Inadequate barrier/warning sign",
     *               "3.2.2 Defective/degraded/Corrosion of Equipment/Tools/Material"
     *           ],
     *           "id": [
     *               "3.2.1 Kurang Penghalang/Tanda Peringatan",
     *               "3.2.2 Peralatan/Alat/Material"
     *           ]
     *       }
     *   }
     */
    public function unsafeCondition(Request $request)
    {
        $result = $this->safetyCardService->unsafeCondition();
        return $this->sendSuccess($result);
    }

    
    /**
     * [10] SC : Unsafe Reason
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "4.1 Lack of Awareness",
     *               "4.2 Lack of training/experience"
     *           ],
     *           "id": [
     *               "4.1 Kurang Peduli",
     *               "4.2 Kurang Pelatihan / Pengalaman"
     *           ]
     *       }
     *   }
     */
    public function unsafeReason(Request $request)
    {
        $result = $this->safetyCardService->unsafeReason();
        return $this->sendSuccess($result);
    }


     /**
     * [11] SC : Life Saving Rules
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "5.1 Fit for Duty",
     *               "5.2 Work Authorization"
     *           ],
     *           "id": [
     *               "5.1 Dalam Kondisi Sehat untuk Bekerja",
     *               "5.2 Otorisasi untuk Bekerja"
     *           ]
     *       }
     *   }
     */
    public function lifeSavingRules(Request $request)
    {
        $result = $this->safetyCardService->lifeSavingRules();
        return $this->sendSuccess($result);
    }

    
     /**
     * [12] SC : Recomendation Category
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "Safety",
     *               "Health"
     *           ],
     *           "id": [
     *               "Safety",
     *               "Health"
     *           ]
     *       }
     *   }
     */
    public function recomendationCategory(Request $request)
    {
        $result = $this->safetyCardService->recomendationCategory();
        return $this->sendSuccess($result);
    }

        
     /**
     * [13] SC : Recomendation Priority
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "data": {
     *           "en": [
     *               "Low",
     *               "Medium"
     *           ],
     *           "id": [
     *               "Rendah",
     *               "Sedang"
     *           ]
     *       }
     *   }
     */
    public function recomendationPriority(Request $request)
    {
        $result = $this->safetyCardService->recomendationPriority();
        return $this->sendSuccess($result);
    }


          
     /**
     * [14] SC : Position
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": {
     *           "en": [
     *               {
     *                   "payroll_id": "20070019",
     *                   "payroll_name": "HENDRA SAPUTRA",
     *                   "position_id": "0000000139",
     *                   "position_name": "BPM ADMIN"
     *               }
     *           ],
     *           "id": [
     *               {
     *                   "payroll_id": "20070019",
     *                   "payroll_name": "HENDRA SAPUTRA",
     *                   "position_id": "0000000139",
     *                   "position_name": "BPM ADMIN"
     *               }
     *           ]
     *       }
     *   }
     */
    public function recomendationPosition(Request $request){
        $user = $this->auth();
        $result = $this->safetyCardService->recomendationPosition($user->email);
        return $this->sendSuccess($result);
    }
    
    /**
     * [15] SC : Submit Safety Card
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam date string required Y-m-d Format
     * @bodyParam category string required 
     * @bodyParam position_id string required 
     * @bodyParam block_function string required 
     * @bodyParam location string required 
     * @bodyParam observation_location string required 
     * @bodyParam company string required 
     * @bodyParam division string required 
     * @bodyParam department string required 
     * @bodyParam report_type string required 
     * @bodyParam posibility_event string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_posibility_event string optional if input other 
     * @bodyParam unsafe_behaivour string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_unsafe_behaivour string optional if input other 
     * @bodyParam unsafe_condition string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_unsafe_condition string optional if input other 
     * @bodyParam unsafe_reason string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_unsafe_reason string optional if input other 
     * @bodyParam life_saving_rule string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam risk_rank string required 
     * @bodyParam brief_desc string required 
     * @bodyParam recomendation_category[0] string required 
     * @bodyParam recomendation_target_date[0] string required 
     * @bodyParam recomendation_finding[0] string required 
     * @bodyParam recomendation_position_name[0] string required 
     * @bodyParam recomendation_position_payroll_name[0] string required 
     * @bodyParam recomendation_position_id[0] string required 
     * @bodyParam recomendation_priority[0] string required 
     * @bodyParam recomendation[0] string required 
     * @bodyParam recomendation_attachments[0][0] file required 
     * @bodyParam recomendation_attachments[0][1] file required 
     * @bodyParam recomendation_attachments[0][2] file required 
     */
    public function store(Request $request,SubmitHseSafetyCardAction $submitHseSafetyCardAction){
        $submitHseSafetyCardAction->handle($request,$this->auth());
        dd($request->all());
    }
    
}
