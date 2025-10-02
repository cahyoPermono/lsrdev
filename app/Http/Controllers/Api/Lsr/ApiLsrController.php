<?php

namespace App\Http\Controllers\Api\Lsr;

use App\Http\Controllers\Controller;
use App\Services\Lsr\LsrService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group LSR (Life Saving Rules)
 * @sorting 15
 */
class ApiLsrController extends ApiController
{
    public function __construct(
        private LsrService $lsrService
    ) {}

    /**
     * LSR : Get List Companies
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Medco E&P Indonesia",
     *       "code": "MEPI",
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function companies(Request $request)
    {
        $companies = $this->lsrService->getCompanies();
        return $this->sendSuccess($companies);
    }

    /**
     * LSR : Get List Blocks
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Block A",
     *       "company_id": 1,
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function blocks(Request $request)
    {
        $blocks = $this->lsrService->getBlocks();
        return $this->sendSuccess($blocks);
    }

    /**
     * LSR : Get List Areas/Fields
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Area 1",
     *       "block_id": 1,
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function areas(Request $request)
    {
        $areas = $this->lsrService->getAreas();
        return $this->sendSuccess($areas);
    }

    /**
     * LSR : Get List Locations
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Jakarta Office",
     *       "area_id": 1,
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function locations(Request $request)
    {
        $locations = $this->lsrService->getLocations();
        return $this->sendSuccess($locations);
    }

    /**
     * LSR : Get List Functions
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Electrical Work",
     *       "code": "ELC",
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function functions(Request $request)
    {
        $functions = $this->lsrService->getFunctions();
        return $this->sendSuccess($functions);
    }

    /**
     * LSR : Get List Categories
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "High Risk",
     *       "description": "High risk activities requiring special permits",
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function categories(Request $request)
    {
        $categories = $this->lsrService->getCategories();
        return $this->sendSuccess($categories);
    }

    /**
     * LSR : Get List Work Verifiers
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "John Doe",
     *       "employee_id": "EMP001",
     *       "department": "HSE",
     *       "email": "john.doe@medcoenergi.com",
     *       "phone": "+62-811-0000-0001",
     *       "created_at": "2024-01-01T00:00:00Z"
     *     }
     *   ]
     * }
     */
    public function workVerifiers(Request $request)
    {
        $workVerifiers = $this->lsrService->getWorkVerifiers();
        return $this->sendSuccess($workVerifiers);
    }

    /**
     * LSR : Get List Submissions
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam status optional Filter by submission status (draft, submitted, approved, rejected)
     * @queryParam work_verifier_id optional Filter by work verifier ID
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "company_id": 1,
     *       "block_id": 1,
     *       "area_id": 1,
     *       "location_id": 1,
     *       "function_id": 1,
     *       "ptw_number": "PTW-2024-001",
     *       "activity_description": "Electrical maintenance work",
     *       "categories": [1, 2],
     *       "start_work_verifier_id": 1,
     *       "questionnaires": [
     *         {
     *           "question_number": "Q001",
     *           "compliance_st1": true,
     *           "deviation_st1": "No deviation",
     *           "compliance_st2": true,
     *           "deviation_st2": "No deviation"
     *         }
     *       ],
     *       "status": "draft",
     *       "created_at": "2024-01-01T08:00:00Z",
     *       "updated_at": "2024-01-01T08:00:00Z"
     *     }
     *   ]
     * }
     */
    public function submissions(Request $request)
    {
        $filters = [];

        // Apply optional filters
        if ($request->has('status')) {
            $filters['status'] = $request->get('status');
        }

        if ($request->has('work_verifier_id')) {
            $filters['work_verifier_id'] = $request->get('work_verifier_id');
        }

        $submissions = $this->lsrService->getSubmissions($filters);
        return $this->sendSuccess($submissions);
    }

    /**
     * LSR : Create New Submission
     *
     * @authenticated
     * @defaultParam
     *
     * @bodyParam user_id integer optional User ID (defaults to 1)
     * @bodyParam company integer required Company ID
     * @bodyParam block integer required Block ID
     * @bodyParam area_field integer required Area/Field ID
     * @bodyParam location integer required Location ID
     * @bodyParam function integer required Function ID
     * @bodyParam ptw_number string required PTW Number
     * @bodyParam activity_description string required Activity description
     * @bodyParam categorys array required Array of category IDs
     * @bodyParam start_work_verifier_id integer required Work verifier ID
     * @bodyParam questionnaires array optional Array of questionnaire objects with compliance data
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "id": 5,
     *     "company_id": 1,
     *     "block_id": 1,
     *     "area_id": 1,
     *     "location_id": 1,
     *     "function_id": 1,
     *     "ptw_number": "PTW-2024-005",
     *     "activity_description": "New electrical work",
     *     "categories": [1, 2],
     *     "start_work_verifier_id": 1,
     *     "status": "draft",
     *     "created_at": "2024-01-05T08:00:00Z",
     *     "updated_at": "2024-01-05T08:00:00Z"
     *   }
     * }
     */
    public function storeSubmission(Request $request)
    {
        // Validate required fields
        $validatedData = $request->validate([
            'user_id' => 'nullable|integer',
            'company' => 'required|integer',
            'block' => 'required|integer',
            'area_field' => 'required|integer',
            'location' => 'required|integer',
            'function' => 'required|integer',
            'ptw_number' => 'required|string',
            'activity_description' => 'required|string',
            'categorys' => 'required|array',
            'start_work_verifier_id' => 'required|integer',
            'questionnaires' => 'nullable|array',
            'questionnaires.*.question_number' => 'required_with:questionnaires|string',
            'questionnaires.*.compliance_st1' => 'required_with:questionnaires|boolean',
            'questionnaires.*.deviation_st1' => 'required_with:questionnaires|string',
            'questionnaires.*.compliance_st2' => 'required_with:questionnaires|boolean',
            'questionnaires.*.deviation_st2' => 'required_with:questionnaires|string'
        ]);

        $submission = $this->lsrService->createSubmission($validatedData);
        return $this->sendSuccess($submission, 'Submission created successfully');
    }

    /**
     * LSR : Update Submission Questionnaires
     *
     * @authenticated
     * @defaultParam
     *
     * @urlParam submission_id integer required The ID of the submission to update
     * @bodyParam questionnaires array required Array of questionnaire objects with compliance data
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "id": 1,
     *     "company_id": 1,
     *     "block_id": 1,
     *     "area_id": 1,
     *     "location_id": 1,
     *     "function_id": 1,
     *     "ptw_number": "PTW-2024-001",
     *     "activity_description": "Electrical maintenance work",
     *     "categories": [1, 2],
     *     "start_work_verifier_id": 1,
     *     "questionnaires": [
     *       {
     *         "question_number": "Q001",
     *         "compliance_st1": true,
     *         "deviation_st1": "No deviation",
     *         "compliance_st2": true,
     *         "deviation_st2": "No deviation"
     *       }
     *     ],
     *     "status": "verified_stage_2",
     *     "created_at": "2024-01-01T08:00:00Z",
     *     "updated_at": "2024-01-05T10:00:00Z"
     *   }
     * }
     *
     * @response 404 {
     *   "status": 404,
     *   "message": "Submission not found",
     *   "data": null
     * }
     */
    public function updateSubmission(Request $request, $submissionId)
    {
        // Validate required fields
        $validatedData = $request->validate([
            'questionnaires' => 'required|array',
            'questionnaires.*.question_number' => 'required|string',
            'questionnaires.*.compliance_st1' => 'required|boolean',
            'questionnaires.*.deviation_st1' => 'required|string',
            'questionnaires.*.compliance_st2' => 'required|boolean',
            'questionnaires.*.deviation_st2' => 'required|string'
        ]);

        $updatedSubmission = $this->lsrService->updateSubmission($submissionId, $validatedData['questionnaires']);

        if ($updatedSubmission === null) {
            return $this->sendError('Submission not found', 404);
        }

        return $this->sendSuccess($updatedSubmission, 'Submission updated successfully');
    }

    /**
     * LSR : Get List Questionnaires
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam stage optional Filter by stage (stage_1, stage_2)
     * @queryParam category optional Filter by category
     * @queryParam required optional Filter by required status (true/false)
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "id": "Q001",
     *       "question": "Apakah semua persyaratan keselamatan telah dipenuhi sebelum memulai pekerjaan?",
     *       "category": "Safety Requirements",
     *       "required": true,
     *       "stage": "stage_1"
     *     },
     *     {
     *       "id": "Q002",
     *       "question": "Apakah semua peralatan PPE telah digunakan dengan benar?",
     *       "category": "PPE Compliance",
     *       "required": true,
     *       "stage": "stage_1"
     *     }
     *   ]
     * }
     */
    public function questionnaires(Request $request)
    {
        $questionnaires = $this->lsrService->getQuestionnaires();

        // Apply optional filters
        if ($request->has('stage')) {
            $questionnaires = array_filter($questionnaires, function($q) use ($request) {
                return $q['stage'] === $request->get('stage');
            });
        }

        if ($request->has('category')) {
            $questionnaires = array_filter($questionnaires, function($q) use ($request) {
                return $q['category'] === $request->get('category');
            });
        }

        if ($request->has('required')) {
            $required = $request->get('required') === 'true';
            $questionnaires = array_filter($questionnaires, function($q) use ($required) {
                return $q['required'] === $required;
            });
        }

        return $this->sendSuccess(array_values($questionnaires));
    }

    /**
     * LSR : Update Submission Status to Not Comply
     *
     * @authenticated
     * @defaultParam
     *
     * @urlParam submission_id integer required The ID of the submission to update
     * @bodyParam reason string optional Reason for non-compliance
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "id": 1,
     *     "company_id": 1,
     *     "block_id": 1,
     *     "area_id": 1,
     *     "location_id": 1,
     *     "function_id": 1,
     *     "ptw_number": "PTW-2024-001",
     *     "activity_description": "Electrical maintenance work",
     *     "categories": [1, 2],
     *     "start_work_verifier_id": 1,
     *     "questionnaires": [],
     *     "status": "not_comply_stage_2",
     *     "not_comply_reason": "Safety protocols not followed",
     *     "created_at": "2024-01-01T08:00:00Z",
     *     "updated_at": "2024-01-05T10:00:00Z"
     *   }
     * }
     *
     * @response 404 {
     *   "status": 404,
     *   "message": "Submission not found",
     *   "data": null
     * }
     */
    public function updateSubmissionStatus(Request $request, $submissionId)
    {
        $validatedData = $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $updatedSubmission = $this->lsrService->updateSubmissionStatus(
            $submissionId,
            $validatedData['reason'] ?? null
        );

        if ($updatedSubmission === null) {
            return $this->sendError('Submission not found', 404);
        }

        return $this->sendSuccess($updatedSubmission, 'Submission status updated to not_comply_stage_2');
    }
}
