<?php

namespace App\Http\Controllers\Api\SelfScreening;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\CompetencyService;
use App\Services\MedcoApi\TrainingService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Self Screening
 * @sorting 3
 */
class ApiSelfScreeningController extends ApiController
{
    public function __construct(
        private TrainingService $trainingService,
        private CompetencyService $competencyService
    ) {
    }

    /**
     * Self : List Training
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "training_name": "Oil Spill Response Level 2",
     *               "validity": 5,
     *               "valid_until": "2020-08-10",
     *               "contract_number": "IDN HSE OHS 0026",
     *               "status": "Active",
     *               "contact_owner": "",
     *               "contract_period": "N/A",
     *               "npwp": "-",
     *               "trainer": "-",
     *               "nik": "",
     *               "location": "",
     *               "position": "ERT Planning Section chief",
     *               "requirement_title": "Oil Spill Response Level 2",
     *               "requirement_type": "HSE Training",
     *               "training_type": "HSE Training",
     *               "last_taken": "2015-08-10",
     *               "mandatory": false,
     *               "personel_type": null,
     *               "detail_category": "one",
     *               "detail": {
     *                   "payroll_id": "32906024",
     *                   "name": "Syarif Budiman",
     *                   "job_role_id": "Suban Operations-25",
     *                   "job_role_name": "ERT Planning Section chief",
     *                   "job_role_effective_date": "2023-01-01",
     *                   "employee_status": "Employee",
     *                   "employee_effective_date": "2023-01-01",
     *                   "course_id": "IDN HSE OHS 0026",
     *                   "course_name": "Oil Spill Response Level 2",
     *                   "course_type": "HSE Training",
     *                   "last_training_date": "2015-08-10",
     *                   "valid_until": "2020-08-10",
     *                   "validity": true,
     *                   "record_id": "32906024-Suban Operations-25-IDN HSE OHS 0026"
     *               }
     *           }
     *       ]
     *   }
     */
    public function training(Request $request)
    {
        $user = $this->auth();
        $items = $this->trainingService->findAllTraining($user->person_id,$user->email);
        return $this->sendSuccess($items);
    }

    /**
     * Self : List Competency
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "competency_name": "Electrical Safety Level 2",
     *       "valid_until": "2023-12-24",
     *       "assessment_result": "Fail",
     *       "assessor": "Rafael Herman MD",
     *       "company": "Farrell and Sons",
     *       "location": "628 Juwan Lakes\nGoyetteburgh, DE 52493",
     *       "assessment_date": "2023-01-23",
     *       "assessment_method": "Test"
     *       }
     *   ]
     *}
     */
    public function competency(Request $request)
    {
        $person_id = $this->auth()->person_id;
        $items = $this->competencyService->findAllCompetency($person_id);
        return $this->sendSuccess($items);
    }
}