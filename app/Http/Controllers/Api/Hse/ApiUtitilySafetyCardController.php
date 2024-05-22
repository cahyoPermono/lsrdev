<?php

namespace App\Http\Controllers\Api\Hse;

use App\Actions\Hse\SubmitHseSafetyCardAction;
use App\Http\Controllers\Controller;
use App\Services\Hse\SafetyCardService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

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
     * [18] SC : Detail Safety Card
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam id string required id list safety card
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "header": {
     *           "safetycard_id": 11375,
     *           "process_id": 15,
     *           "creation_date": "2024-05-21T15:10:34.647",
     *           "payroll_id": "20070019",
     *           "payroll_name": "HENDRA SAPUTRA",
     *           "position_id": "0000000139",
     *           "position_name": "BPM ADMIN",
     *           "onbehalf_payroll_id": null,
     *           "onbehalf_payroll_name": null,
     *           "onbehalf_position_id": null,
     *           "onbehalf_position_name": null,
     *           "category": "Occupational Safety",
     *           "date": "2024-05-21T00:00:00",
     *           "block_or_function": "Bangkanai",
     *           "location": "Bangkanai",
     *           "obs_location": "Bangkanai",
     *           "obs_name": "",
     *           "company": null,
     *           "division": null,
     *           "department": "ACCOUNTING SERVICES - BUSINESS EXPENSES SETTLEMENT",
     *           "pts_no": "",
     *           "report_type": "Perilaku Aman",
     *           "main_attachment": null
     *       },
     *       "possibility_of_event": {
     *           "_2_4": false,
     *           "_2_5": true,
     *           "_2_7_text": "OTHER"
     *       },
     *       "unsafe_behaviour": {
     *           "_3_1_1": false,
     *           "_3_1_2": true,
     *           "_3_1_12_text": "OTH"
     *       },
     *       "unsafe_condition": {
     *           "_3_2_2": false,
     *           "_3_2_3": true,
     *           "_3_2_11_text": "USF OTH"
     *       },
     *       "unsafe_reason": {
     *           "_4_1": true,
     *           "_4_2": false,
     *           "_4_14_text": "5.1 Fit for Duty"
     *       },
     *       "life_saving_rules": {
     *           "_5_1": false,
     *           "_5_2": true
     *       },
     *       "footer": {
     *           "risk_rank": "Rendah",
     *           "brief_desc": null,
     *           "appreciation": ""
     *       },
     *       "recommendations": [
     *           {
     *               "finding": "FINDING VALUE",
     *               "recommendation": "WAHHH",
     *               "target_completed_date": "2024-05-27T00:00:00",
     *               "recommendation_category": "Safety",
     *               "block": "Bangkanai",
     *               "location": "Bangkanai",
     *               "resp_person_name": "HENDRA SAPUTRA",
     *               "resp_person_payroll": "20070019",
     *               "resp_person_positionid": "0000000139",
     *               "resp_person_division": null,
     *               "resp_person_dept": null,
     *               "priority": "Low",
     *               "attachments": {
     *                   "att1": "2f094498-5d07-4a18-9e2e-3c05c2a9cf10_MwmSvocJsxKQzLUGqipiGF8gqBYG5pFLG19jaK4S.png",
     *                   "att2": null,
     *                   "att3": null
     *               }
     *           }
     *       ]
     *   }
     *}
     */
    public function detail(Request $request,$id){
        $result = $this->safetyCardService->detil($id);
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
     * @bodyParam attachment file required 
     * @bodyParam posibility_event string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_posibility_event string optional if input other 
     * @bodyParam unsafe_behaivour string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_unsafe_behaivour string optional if input other 
     * @bodyParam unsafe_condition string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_unsafe_condition string optional if input other 
     * @bodyParam unsafe_reason string optional multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam other_unsafe_reason string optional if input other 
     * @bodyParam life_saving_rule string required multiple from checkbox, separate with (,) : ex ABC,DEF,GHI
     * @bodyParam risk_rank string required 
     * @bodyParam brief_description string required 
     * @bodyParam recomendation_category[0] string required 
     * @bodyParam recomendation_target_date[0] string required 
     * @bodyParam recomendation_finding[0] string required 
     * @bodyParam recomendation_position_payroll_id[0] string required 
     * @bodyParam recomendation_position_payroll_name[0] string required 
     * @bodyParam recomendation_position_id[0] string required 
     * @bodyParam recomendation_priority[0] string required 
     * @bodyParam recomendation[0] string required 
     * @bodyParam recomendation_attachments[0][0] file required 
     * @bodyParam recomendation_attachments[0][1] file required 
     * @bodyParam recomendation_attachments[0][2] file required 
     * 
     * @response {
     *   "status": 200,
     *   "message": "success"
     *   }
     */
    public function store(Request $request,SubmitHseSafetyCardAction $submitHseSafetyCardAction){
        try{
            $this->validates([
                'position_id' => 'required',
                'category' => 'required',
                'date' => 'required',
                'block_function' => 'required',
                'location' => 'required',
                'observation_location' => 'required',
                'company' => 'required',
                'division' => 'required',
                'department' => 'required',
                'report_type' => 'required',
                // 'posibility_event' => 'required',
                // 'unsafe_behaivour' => 'required',
                // 'unsafe_condition' => 'required',
                // 'unsafe_reason' => 'required',
                // 'life_saving_rule' => 'required',
                'risk_rank' => 'required',
                'brief_description' => 'required',
                'recomendation_category.*' => 'required',
                'recomendation_finding.*' => 'required',
                'recomendation.*' => 'required',
                'recomendation_target_date.*' => 'required',
                'recomendation_position_id.*' => 'required',
                'recomendation_position_payroll_id.*' => 'required',
                'recomendation_position_payroll_name.*' => 'required',
                'recomendation_priority.*' => 'required',
           ]);
            $submitHseSafetyCardAction->handle($request,$this->auth());
            return $this->sendMessage('success');
        }catch(BadRequestException $e){
            return $this->badRequest($e->getMessage());
        }
    }
    
}
