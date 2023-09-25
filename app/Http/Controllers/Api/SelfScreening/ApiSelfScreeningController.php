<?php

namespace App\Http\Controllers\Api\SelfScreening;

use App\Http\Controllers\Controller;
use App\Services\MedcoApi\CompetencyService;
use App\Services\MedcoApi\TrainingService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Self Screening
 */
class ApiSelfScreeningController extends ApiController
{
    public function __construct(
        private TrainingService $trainingService,
        private CompetencyService $competencyService
    ) {
    }

    /**
     * List Training
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *       {
     *       "training_name": "Medical Check Up",
     *       "valid_until": "2023-12-16",
     *       "contract_number": 287467,
     *       "status": "Active",
     *       "contact_owner": "Mr. Geovany Kling",
     *       "contract_period": "35 Months",
     *       "npwp": "01.365.921.4-073.999",
     *       "trainer": "Hosea McDermott",
     *       "nik": "190933303993541706",
     *       "location": "612 Gleichner Stravenue\nEast Metaborough, NV 30983-5281",
     *       "position": "D/CADET (ABPL)",
     *       "requirement_title": "Medical Check Up",
     *       "requirement_type": "MCU",
     *       "training_type": "Technical Training",
     *       "last_taken": "00:00,0",
     *       "mandatory": "Yes",
     *       "personel_type": null
     *       }
     *   ]
     * }
     */
    public function training(Request $request)
    {
        $person_id = $this->auth()->person_id;
        $items = $this->trainingService->findAllTraining($person_id);
        return $this->sendSuccess($items);
    }

    /**
     * List Competency
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