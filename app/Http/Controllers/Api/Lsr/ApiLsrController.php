<?php

namespace App\Http\Controllers\Api\Lsr;

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
     * LSR : Get LSR History List
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "BPMIDLSRstage1": 123,
     *       "LSRCategory": 1,
     *       "PTWNo": "PTW-2024-001",
     *       "Statusworkflowprocess": "Completed",
     *       "DatesubmissionStage1": "2024-01-01T08:00:00Z",
     *       "InitiatorName": "John Doe",
     *       "WorkerVerifierName": "Jane Smith",
     *       "LSRCategoryName": "High Risk",
     *       "ActivityDesc": "Electrical maintenance work",
     *       "Current_Activity_StartDate": "2024-01-01T08:00:00Z"
     *     }
     *   ]
     * }
     */
    public function historyList(Request $request)
    {
        $email = $this->auth()->email;
        $historyList = $this->lsrService->getLSRHistoryList(
            $email,
        );
        return $this->sendSuccess($historyList);
    }

    /**
     * LSR : Get LSR Task Todo
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam responsibleUserID optional Responsible user ID filter
     * @queryParam responsibleUserEmail optional Responsible user email filter
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "BPMIDLSRstage1": 124,
     *       "LSRCategory": 2,
     *       "PTWNo": "PTW-2024-002",
     *       "Statusworkflowprocess": "In Progress",
     *       "DatesubmissionStage1": "2024-01-02T09:00:00Z"
     *     }
     *   ]
     * }
     */
    public function taskTodo(Request $request)
    {
        $taskTodo = $this->lsrService->getLSRTaskTodo(
            $request->get('responsibleUserID'),
            $request->get('responsibleUserEmail')
        );
        return $this->sendSuccess($taskTodo);
    }

    /**
     * LSR : Search LSR
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam email optional Email filter
     * @queryParam ptwNumber optional PTW number filter
     * @queryParam processID optional Process ID filter
     * @queryParam category optional Category filter
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "BPMIDLSRstage1": 125,
     *     "LSRCategory": 1,
     *     "PTWNo": "PTW-2024-003",
     *     "Statusworkflowprocess": "Pending",
     *     "DatesubmissionStage1": "2024-01-03T10:00:00Z"
     *   }
     * }
     */
    public function search(Request $request)
    {
        $searchResult = $this->lsrService->searchLSR(
            $request->get('email'),
            $request->get('ptwNumber'),
            $request->get('processID'),
            $request->get('category')
        );
        return $this->sendSuccess($searchResult);
    }

    /**
     * LSR : Get LSR Detail
     *
     * @authenticated
     * @defaultParam
     *
     * @urlParam id integer required LSR ID
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "Id": 123,
     *     "ProcessId": 456,
     *     "CreationDate": "2024-01-01T08:00:00Z",
     *     "Payroll": "EMP001",
     *     "Name": "John Doe",
     *     "Company": "Medco E&P",
     *     "PTWNumber": "PTW-2024-001",
     *     "ActivityDesc": "Electrical maintenance work",
     *     "Status": 1
     *   }
     * }
     */
    public function detail(Request $request, $id)
    {
        $detail = $this->lsrService->getLSRDetail($id);

        if (!$detail) {
            return $this->sendError('LSR detail not found', 404);
        }

        return $this->sendSuccess($detail);
    }

    /**
     * LSR : Get Company List
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam searchParam optional Search parameter
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "Medco E&P Indonesia",
     *       "Value": "MEPI"
     *     }
     *   ]
     * }
     */
    public function companiesFromApi(Request $request)
    {
        $companies = $this->lsrService->getCompany($request->get('searchParam'));
        return $this->sendSuccess($companies);
    }

    /**
     * LSR : Get Block List
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "Block A",
     *       "Value": "BLOCK_A"
     *     }
     *   ]
     * }
     */
    public function blocksFromApi(Request $request)
    {
        $blocks = $this->lsrService->getBlock();
        return $this->sendSuccess($blocks);
    }

    /**
     * LSR : Get Area Field List
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam Block required Block parameter
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "Area 1",
     *       "Value": "AREA_1"
     *     }
     *   ]
     * }
     */
    public function areaFields(Request $request)
    {
        $block = $request->get('Block');
        if (!$block) {
            return $this->sendError('Block parameter is required', 400);
        }

        $areaFields = $this->lsrService->getAreaField($block);
        return $this->sendSuccess($areaFields);
    }

    /**
     * LSR : Get Location List
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "Jakarta Office",
     *       "Value": "JKT_OFFICE"
     *     }
     *   ]
     * }
     */
    public function locationsFromApi(Request $request)
    {
        $locations = $this->lsrService->getLocation();
        return $this->sendSuccess($locations);
    }

    /**
     * LSR : Get Function List
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "Electrical Work",
     *       "Value": "ELC"
     *     }
     *   ]
     * }
     */
    public function functionsFromApi(Request $request)
    {
        $functions = $this->lsrService->getFunction();
        return $this->sendSuccess($functions);
    }

    /**
     * LSR : Get LSR Category List
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "High Risk",
     *       "Value": "1"
     *     }
     *   ]
     * }
     */
    public function categoriesFromApi(Request $request)
    {
        $categories = $this->lsrService->getLSRCategory();
        return $this->sendSuccess($categories);
    }

    /**
     * LSR : Get LSR Subcategory List
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam LSRCatId required LSR Category ID
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Text": "Electrical High Risk",
     *       "Value": "1"
     *     }
     *   ]
     * }
     */
    public function subcategories(Request $request)
    {
        $lsrCatId = $request->get('LSRCatId');
        if (!$lsrCatId) {
            return $this->sendError('LSRCatId parameter is required', 400);
        }

        $subcategories = $this->lsrService->getLSRSubcategory($lsrCatId);
        return $this->sendSuccess($subcategories);
    }

    /**
     * LSR : Get Personnel List
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam name optional Name filter
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Name": "John Doe",
     *       "Email": "john.doe@medcoenergi.com",
     *       "MSID": "EMP001"
     *     }
     *   ]
     * }
     */
    public function personnel(Request $request)
    {
        $personnel = $this->lsrService->getPersonnelList($request->get('name'));
        return $this->sendSuccess($personnel);
    }

    /**
     * LSR : Get Checklist
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam LSRCatId required LSR Category ID
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "ParentId": 1,
     *       "LSRCatId": 1,
     *       "LSRChecklistName": "Safety helmet check",
     *       "ChecklistWorker": 1,
     *       "ChecklistWorkVerifier": 1,
     *       "ChecklistFieldVerificator": 1
     *     }
     *   ]
     * }
     */
    public function checklist(Request $request)
    {
        $lsrCatId = $request->get('LSRCatId');
        if (!$lsrCatId) {
            return $this->sendError('LSRCatId parameter is required', 400);
        }

        $checklist = $this->lsrService->getChecklist($lsrCatId);
        return $this->sendSuccess($checklist);
    }

    /**
     * LSR : Post LSR
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam action required Action parameter
     * @bodyParam model object required LSR model data
     * @bodyParam model.Id integer LSR Id. Example: 3339
     * @bodyParam model.ProcessId integer Process Id. Example: 5052
     * @bodyParam model.OldProcessId integer optional Old Process Id. Example: 7375
     * @bodyParam model.CreationDate datetime optional Creation date (ISO8601). Example: 1983-06-24T00:40:30.803Z
     * @bodyParam model.CompletionDate datetime optional Completion date (ISO8601). Example: 2018-02-03T18:07:58.866Z
     * @bodyParam model.Payroll string optional Payroll code. Example: string
     * @bodyParam model.Name string optional Person name. Example: string
     * @bodyParam model.Position string optional Position id. Example: string
     * @bodyParam model.PositionName string optional Position name. Example: string
     * @bodyParam model.Company string optional Company name. Example: string
     * @bodyParam model.BlockFunction string optional Block / Function. Example: string
     * @bodyParam model.AreaField string optional Area / Field. Example: string
     * @bodyParam model.Location string optional Location. Example: string
     * @bodyParam model.PTWNumber string optional PTW number. Example: string
     * @bodyParam model.ActivityDesc string optional Activity description. Example: string
     * @bodyParam model.LSRCat integer optional LSR Category id. Example: 31
     * @bodyParam model.Stage1SubmissionDate datetime optional Stage 1 submission date (ISO8601). Example: 1952-12-17T19:48:11.906Z
     * @bodyParam model.Stage2SubmissionDate datetime optional Stage 2 submission date (ISO8601). Example: 2007-11-21T17:33:24.706Z
     * @bodyParam model.Stage3SubmissionDate datetime optional Stage 3 submission date (ISO8601). Example: 1957-04-10T20:01:42.652Z
     * @bodyParam model.WorkerSupervisorName string optional Worker supervisor name. Example: string
     * @bodyParam model.WorkerSupervisorPayroll string optional Worker supervisor payroll. Example: string
     * @bodyParam model.WorkerSupervisorPositionId string optional Worker supervisor position id. Example: string
     * @bodyParam model.WorkerVerifierName string optional Worker verifier name. Example: string
     * @bodyParam model.WorkerVerifierPayroll string optional Worker verifier payroll. Example: string
     * @bodyParam model.WorkerVerifierPositionId string optional Worker verifier position id. Example: string
     * @bodyParam model.FieldVerificatorName string optional Field verificator name. Example: string
     * @bodyParam model.FieldVerificatorPayroll string optional Field verificator payroll. Example: string
     * @bodyParam model.FieldVerificatorPositionId string optional Field verificator position id. Example: string
     * @bodyParam model.Status integer optional Status code. Example: 9428
     * @bodyParam model.ChecklistIdGenerated integer optional Generated checklist id. Example: 7264
     * @bodyParam model.AdhocPosName string optional Adhoc position name. Example: string
     * @bodyParam model.AdhocPosition string optional Adhoc position id. Example: string
     * @bodyParam model.LSRSubCat integer optional LSR Subcategory id. Example: 1919
     * @bodyParam model.Functions string optional Functions. Example: string
     * @bodyParam model.Email string optional Email. Example: string
     * @bodyParam model.MSID string optional MSID. Example: string
     * @bodyParam model.MSID_Name string optional MSID name. Example: string
     * @bodyParam model.Current_UserEmail string optional Current user email. Example: string
     * @bodyParam model.Current_User string optional Current user id. Example: string
     * @bodyParam model.Current_Activity string optional Current activity. Example: string
     * @bodyParam model.Current_Activity_StartDate datetime optional Current activity start date (ISO8601). Example: 2005-06-13T23:30:56.891Z
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "Status": true,
     *     "Message": "LSR submitted successfully"
     *   }
     * }
     */
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|string',
            'model' => 'required|array'
        ]);

        $result = $this->lsrService->postLSR($validatedData['model'], $validatedData['action']);
        return $this->sendSuccess($result);
    }

    /**
     * LSR : Post LSR Verify
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "Status": true,
     *     "Message": "LSR verified successfully"
     *   }
     * }
     */
    public function verify(Request $request)
    {
        $result = $this->lsrService->postLSRVerify();
        return $this->sendSuccess($result);
    }

    /**
     * LSR : Post LSR Route To Initiator
     *
     * @authenticated
     * @defaultParam
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *     "Status": true,
     *     "Message": "LSR routed to initiator successfully"
     *   }
     * }
     */
    public function routeToInitiator(Request $request)
    {
        $result = $this->lsrService->postLSRRouteToInitiator();
        return $this->sendSuccess($result);
    }
}
