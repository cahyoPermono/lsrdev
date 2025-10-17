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
        $email = $this->auth()->email;
        $taskTodo = $this->lsrService->getLSRTaskTodo(
            $email,
        );
        return $this->sendSuccess($taskTodo);
    }

    /**
     * LSR : Search LSR
     *
     * @authenticated
     * @defaultParam
     *
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
        $email = $this->auth()->email;
        $searchResult = $this->lsrService->searchLSR(
            $email,
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
     *    "Details": [
     *        {
     *            "Id": 6077,
     *            "ProcessId": -3268,
     *            "Payroll": "",
     *            "LSRCatId": 8,
     *            "IdByCat": 1,
     *            "ChecklistWorker": 1,
     *            "ChecklistWorkVerifier": null,
     *            "ChecklistFieldVerificator": null,
     *            "NonCompliancesDetail1": "",
     *            "NonCompliancesDetail2": null,
     *            "NonCompliancesDetail3": null,
     *            "ChecklistIdGenerated": null,
     *            "Email": "medcoweb.uat1@medcoenergi.com"
     *        }
     *    ],
     *    "Id": 3268,
     *    "ProcessId": -3268,
     *    "OldProcessId": null,
     *    "CreationDate": "2025-10-14T00:00:00",
     *    "CompletionDate": null,
     *    "Payroll": "",
     *    "Name": "",
     *    "Position": "Contractor",
     *    "PositionName": null,
     *    "Company": "string",
     *    "BlockFunction": "Bangkanai",
     *    "AreaField": "Luwehulu",
     *    "Location": "Office",
     *    "PTWNumber": "17081945",
     *    "ActivityDesc": "Mengangkat sesuatu",
     *    "LSRCat": 8,
     *    "Stage1SubmissionDate": "2025-10-14T00:00:00",
     *    "Stage2SubmissionDate": null,
     *    "Stage3SubmissionDate": null,
     *    "WorkerSupervisorName": null,
     *    "WorkerSupervisorPayroll": null,
     *    "WorkerSupervisorPositionId": null,
     *    "WorkerVerifierName": "Naufal Adi Wijanarko",
     *    "WorkerVerifierPayroll": null,
     *    "WorkerVerifierPositionId": null,
     *    "FieldVerificatorName": null,
     *    "FieldVerificatorPayroll": null,
     *    "FieldVerificatorPositionId": null,
     *    "Status": null,
     *    "ChecklistIdGenerated": null,
     *    "AdhocPosName": null,
     *    "AdhocPosition": null,
     *    "LSRSubCat": null,
     *    "Functions": "Operations",
     *    "Email": "medcoweb.uat1@medcoenergi.com",
     *    "MSID": "",
     *    "MSID_Name": "",
     *    "Current_UserEmail": "medcoweb.uat1@medcoenergi.com",
     *    "Current_User": "medcoweb.uat1@medcoenergi.com",
     *    "Current_Activity": "Work Verifier Approval",
     *    "Current_Activity_StartDate": "2025-10-14T00:00:00",
     *    "WorkerVerifierEmail": "naufal.wijanarko@sc.medcoenergi.com"
     *   }
     *  }
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
     * @bodyParam Id integer LSR Id. Example: 474
     * @bodyParam Current_UserEmail string Current user email. Example: string
     * @bodyParam Company string Company name. Example: string
     * @bodyParam BlockFunction string Block / Function. Example: string
     * @bodyParam AreaField string Area / Field. Example: string
     * @bodyParam Location string Location. Example: string
     * @bodyParam PTWNumber string PTW number. Example: string
     * @bodyParam ActivityDesc string Activity description. Example: string
     * @bodyParam LSRCat integer LSR Category id. Example: 4219
     * @bodyParam LSRSubCat integer LSR Category id. Example: 4219
     * @bodyParam WorkerVerifierEmail string Worker verifier email. Example: string
     * @bodyParam Functions string Functions. Example: string
     * @bodyParam Details array Details array containing checklist items
     * @bodyParam Details[].LSRCatId integer LSR Category ID. Example: 2592
     * @bodyParam Details[].IdByCat integer ID by category. Example: 9542
     * @bodyParam Details[].ChecklistWorker integer Checklist worker status (0 or 1). Example: 0
     * @bodyParam Details[].NonCompliancesDetail string Non compliances detail. Example: string
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
        $model = $request->all();
        //change Current_UserEmail = $this->auth()->email;
        $model['Current_UserEmail'] = $this->auth()->email;
        $result = $this->lsrService->postLSR($model);
        return $this->sendSuccess($result);
    }

    /**
     * LSR : Post LSR Verify
     *
     * @authenticated
     * @defaultParam
     * @bodyParam Id integer LSR Id. Example: 474
     * @bodyParam Current_UserEmail string Current user email. Example: string
     * @bodyParam Company string Company name. Example: string
     * @bodyParam BlockFunction string Block / Function. Example: string
     * @bodyParam AreaField string Area / Field. Example: string
     * @bodyParam Location string Location. Example: string
     * @bodyParam PTWNumber string PTW number. Example: string
     * @bodyParam ActivityDesc string Activity description. Example: string
     * @bodyParam LSRCat integer LSR Category id. Example: 4219
     * @bodyParam LSRSubCat integer LSR Category id. Example: 4219
     * @bodyParam WorkerVerifierEmail string Worker verifier email. Example: string
     * @bodyParam Functions string Functions. Example: string
     * @bodyParam Details array Details array containing checklist items
     * @bodyParam Details[].LSRCatId integer LSR Category ID. Example: 2592
     * @bodyParam Details[].IdByCat integer ID by category. Example: 9542
     * @bodyParam Details[].ChecklistWorker integer Checklist worker status (0 or 1). Example: 0
     * @bodyParam Details[].NonCompliancesDetail string Non compliances detail. Example: string
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
        $result = $this->lsrService->postLSRVerify($request->all());
        return $this->sendSuccess($result);
    }

    /**
     * LSR : Post LSR Route To Initiator
     *
     * @authenticated
     * @defaultParam
     *
     * @bodyParam Id integer LSR Id. Example: 474
     * @bodyParam Current_UserEmail string Current user email. Example: string
     * @bodyParam Company string Company name. Example: string
     * @bodyParam BlockFunction string Block / Function. Example: string
     * @bodyParam AreaField string Area / Field. Example: string
     * @bodyParam Location string Location. Example: string
     * @bodyParam PTWNumber string PTW number. Example: string
     * @bodyParam ActivityDesc string Activity description. Example: string
     * @bodyParam LSRCat integer LSR Category id. Example: 4219
     * @bodyParam LSRSubCat integer LSR Category id. Example: 4219
     * @bodyParam WorkerVerifierEmail string Worker verifier email. Example: string
     * @bodyParam Functions string Functions. Example: string
     * @bodyParam Details array Details array containing checklist items
     * @bodyParam Details[].LSRCatId integer LSR Category ID. Example: 2592
     * @bodyParam Details[].IdByCat integer ID by category. Example: 9542
     * @bodyParam Details[].ChecklistWorker integer Checklist worker status (0 or 1). Example: 0
     * @bodyParam Details[].NonCompliancesDetail string Non compliances detail. Example: string
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
        $result = $this->lsrService->postLSRRouteToInitiator($request->all());
        return $this->sendSuccess($result);
    }
}
