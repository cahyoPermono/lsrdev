<?php

namespace App\Http\Controllers\Api\Lsr;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group LSR (Life Saving Rules) Development
 * @sorting 16
 */
class ApiLsrDevController extends ApiController
{
    private string $dataPath;

    public function __construct()
    {
        $this->dataPath = storage_path('dummy-data/lsr/');
    }

    /**
     * Get LSR History List (Development)
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
        $data = $this->getJsonData('lsr-data.json');

        // Apply filters if provided
        $filteredData = array_filter($data, function ($item) use ($request) {
            $email = $this->auth()->email;
            // Filter by responsible user email (using WorkerVerifierEmail field)
            if (isset($item['Current_UserEmail']) && $item['Current_UserEmail'] != $email) {
                return false;
            }

            return true;
        });

        // Reset array keys to ensure clean array output
        $filteredData = array_values($filteredData);

        // Map filtered data from lsr-task-todo.json to expected format
        $mappedData = array_map(function ($item) {
            return [
                'BPMIDLSRstage1' => $item['Id'],
                'LSRCategory' => $item['LSRCat'] ?? 1,
                'PTWNo' => $item['PTWNumber'] ?? '',
                'Statusworkflowprocess' => $item['Status'],
                'DatesubmissionStage1' => $item['CreationDate'],
                'InitiatorName' => $item['Current_User'] ?? '',
                'WorkerVerifierName' => $item['WorkerVerifierName'] ?? '',
                'LSRCategoryName' => $item['LSRCategoryName'] ?? '',
            ];
        }, $filteredData);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $mappedData
        ]);
    }

    /**
     * Get Checklist (Development)
     *
     * @authenticated
     * @defaultParam
     *
     * @queryParam LSRCatId optional LSR Category ID filter
     *
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": [
     *     {
     *       "Id": 7244,
     *       "LSRCatId": 2630,
     *       "IdByCat": 7008,
     *       "LSRChecklistName": "Safety helmet check",
     *       "isGrayArea": 2156,
     *       "ChecklistWorker": 1,
     *       "ChecklistWorkVerifier": 1,
     *       "ChecklistFieldVerificator": 1
     *     }
     *   ]
     * }
     */
    public function checklist(Request $request): JsonResponse
    {
        $lsrCatId = $request->get('LSRCatId');

        $data = $this->getJsonData('lsr-checklist.json');

        // If LSRCatId is provided, filter by it; otherwise return all data
        if ($lsrCatId) {
            // Filter by LSRCatId and ensure we have valid data
            $filteredData = array_filter($data, function ($item) use ($lsrCatId) {
                return isset($item['LSRCatId']) && $item['LSRCatId'] == $lsrCatId;
            });
        } else {
            // No filter provided, use all data
            $filteredData = $data;
        }

        // Reset array keys to ensure clean array output
        $filteredData = array_values($filteredData);

        // Map the data to include additional fields expected by the frontend
        $mappedData = array_map(function ($item) {
            return [
                'Id' => $item['Id'] ?? null,
                'LSRCatId' => $item['LSRCatId'] ?? null,
                'IdByCat' => $item['IdByCat'] ?? null,
                'LSRChecklistName' => $item['LSRChecklistName'] ?? '',
                'isGrayArea' => $item['isGrayArea'] ?? null,
                'ChecklistWorker' => 1, // Default to 1 (checked) for new checklist items
                'ChecklistWorkVerifier' => 1, // Default to 1 for verifier
                'ChecklistFieldVerificator' => 1 // Default to 1 for field verificator
            ];
        }, $filteredData);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $mappedData
        ]);
    }

    /**
     * Get LSR Task Todo (Development)
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
    public function taskTodo(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-data.json');

        // Apply filters if provided
        $filteredData = array_filter($data, function ($item) use ($request) {
            $responsibleUserID = $request->get('responsibleUserID');
            $responsibleUserEmail = $request->get('responsibleUserEmail');

            // Filter by responsible user ID (using Current_MSID field)
            if ($responsibleUserID && isset($item['Current_MSID']) && $item['Current_MSID'] != $responsibleUserID) {
                return false;
            }

            // Filter by responsible user email (using WorkerVerifierEmail field)
            if ($responsibleUserEmail && isset($item['WorkerVerifierEmail']) && $item['WorkerVerifierEmail'] != $responsibleUserEmail) {
                return false;
            }

            return true;
        });

        // Reset array keys to ensure clean array output
        $filteredData = array_values($filteredData);

        // Map filtered data from lsr-task-todo.json to expected format
        $mappedData = array_map(function ($item) {
            return [
                'BPMIDLSRstage1' => $item['Id'],
                'LSRCategory' => $item['LSRCat'] ?? 1,
                'PTWNo' => $item['PTWNumber'] ?? '',
                'Statusworkflowprocess' => $item['Status'],
                'DatesubmissionStage1' => $item['CreationDate'],
                'InitiatorName' => $item['Current_User'] ?? '',
                'WorkerVerifierName' => $item['WorkerVerifierName'] ?? '',
                'LSRCategoryName' => $item['LSRCategoryName'] ?? ''
            ];
        }, $filteredData);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $mappedData
        ]);
    }

    /**
     * Search LSR (Development)
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
    public function search(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-data.json');

        // Apply filters if provided
        $filteredData = array_filter($data, function ($item) use ($request) {
            $email = $request->get('email');
            $ptwNumber = $request->get('ptwNumber');
            $processID = $request->get('processID');
            $category = $request->get('category');

            // Filter by email (using Email field)
            if ($email && isset($item['Email']) && $item['Email'] != $email) {
                return false;
            }

            // Filter by PTW number (using PTWNumber field)
            if ($ptwNumber && isset($item['PTWNumber']) && $item['PTWNumber'] != $ptwNumber) {
                return false;
            }

            // Filter by process ID (using ProcessId field)
            if ($processID && isset($item['ProcessId']) && $item['ProcessId'] != $processID) {
                return false;
            }

            // Filter by category (using LSRCat field)
            if ($category && isset($item['LSRCat']) && $item['LSRCat'] != $category) {
                return false;
            }

            return true;
        });

        // Reset array keys to ensure clean array output
        $filteredData = array_values($filteredData);

        // Map filtered data from lsr-data.json to expected format
        $mappedData = array_map(function ($item) {
            return [
                'BPMIDLSRstage1' => $item['Id'],
                'LSRCategory' => $item['LSRCat'] ?? 1,
                'PTWNo' => $item['PTWNumber'] ?? '',
                'Statusworkflowprocess' => $item['Status'],
                'DatesubmissionStage1' => $item['CreationDate'],
                'InitiatorName' => $item['Current_User'] ?? '',
                'WorkerVerifierName' => $item['WorkerVerifierName'] ?? '',
                'LSRCategoryName' => $item['LSRCategoryName'] ?? '',
            ];
        }, $filteredData);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $mappedData
        ]);
    }

    /**
     * Get LSR Detail (Development)
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
    public function detail(Request $request, $id): JsonResponse
    {
        // Validate that id parameter is provided
        if (!$id) {
            return response()->json([
                'status' => 400,
                'message' => 'LSR ID parameter is required'
            ], 400);
        }

        $data = $this->getJsonData('lsr-data.json');

        // Find the specific LSR record by ID
        $lsrRecord = null;
        foreach ($data as $item) {
            if (isset($item['Id']) && $item['Id'] == $id) {
                $lsrRecord = $item;
                break;
            }
        }

        // Return 404 if record not found
        if ($lsrRecord === null) {
            return response()->json([
                'status' => 404,
                'message' => 'LSR record not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $lsrRecord
        ]);
    }

    /**
     * Get Company List (Development)
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
    public function companiesFromApi(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-companies.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get Block List (Development)
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
    public function blocksFromApi(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-blocks.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get Area Field List Development
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
    public function areaFields(Request $request): JsonResponse
    {
        $block = $request->get('Block');
        if (!$block) {
            return response()->json([
                'status' => 400,
                'message' => 'Block parameter is required'
            ], 400);
        }

        $data = $this->getJsonData('lsr-area-fields.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get Location List (Development)
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
    public function locationsFromApi(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-locations.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get Function List (Development)
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
    public function functionsFromApi(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-functions.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get LSR Category List (Development)
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
    public function categoriesFromApi(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-categories.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get LSR Subcategory List (Development)
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
    public function subcategories(Request $request): JsonResponse
    {
        $lsrCatId = $request->get('LSRCatId');
        if (!$lsrCatId) {
            return response()->json([
                'status' => 400,
                'message' => 'LSRCatId parameter is required'
            ], 400);
        }

        $data = $this->getJsonData('lsr-subcategories.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get Personnel List (Development)
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
    public function personnel(Request $request): JsonResponse
    {
        $data = $this->getJsonData('lsr-personnel.json');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }



    /**
     * Post LSR (Development)
     *
     * @authenticated
     * @defaultParam
     *
     * @bodyParam Id integer LSR Id. Example: 474
     * @bodyParam Current_User string Current user. Example: string
     * @bodyParam Current_UserEmail string Current user email. Example: string
     * @bodyParam Current_MSID string Current MSID. Example: string
     * @bodyParam Company string Company name. Example: string
     * @bodyParam BlockFunction string Block / Function. Example: string
     * @bodyParam AreaField string Area / Field. Example: string
     * @bodyParam Location string Location. Example: string
     * @bodyParam PTWNumber string PTW number. Example: string
     * @bodyParam ActivityDesc string Activity description. Example: string
     * @bodyParam LSRCat integer LSR Category id. Example: 4219
     * @bodyParam WorkerVerifierName string Worker verifier name. Example: string
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
    public function submit(Request $request): JsonResponse
    {
        try {
            // Get the new request body format directly
            $requestData = $request->all();

            // Validate required fields
            if (!$requestData) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Request data is required',
                    'data' => [
                        'Status' => false,
                        'Message' => 'Request data is required'
                    ]
                ], 400);
            }

            // Read existing data from lsr-data.json
            $existingData = $this->getJsonData('lsr-data.json');

            // Generate new ID (find the highest existing ID and add 1)
            $maxId = 0;
            foreach ($existingData as $item) {
                if (isset($item['Id']) && $item['Id'] > $maxId) {
                    $maxId = $item['Id'];
                }
            }
            $newId = $maxId + 1;

            // Generate new ProcessId if not provided
            $newProcessId = isset($existingData[0]['ProcessId']) ? $existingData[0]['ProcessId'] + 1 : 1;

            // Process Details array to map NonCompliancesDetail to NonCompliancesDetail1
            $processedDetails = [];
            if (isset($requestData['Details']) && is_array($requestData['Details'])) {
                foreach ($requestData['Details'] as $detail) {
                    $processedDetail = $detail;

                    // Map NonCompliancesDetail to NonCompliancesDetail1
                    if (isset($detail['NonCompliancesDetail'])) {
                        $processedDetail['NonCompliancesDetail1'] = $detail['NonCompliancesDetail'];
                    }

                    $processedDetails[] = $processedDetail;
                }
            }

            // Create new LSR data entry with the new format
            $newLsrData = [
                'Id' => $newId,
                'ProcessId' => $newProcessId,
                'CreationDate' => now()->toISOString(),
                'Current_User' => $requestData['Current_User'] ?? '',
                'Current_UserEmail' => $requestData['Current_UserEmail'] ?? '',
                'Current_MSID' => $requestData['Current_MSID'] ?? '',
                'Company' => $requestData['Company'] ?? '',
                'BlockFunction' => $requestData['BlockFunction'] ?? '',
                'AreaField' => $requestData['AreaField'] ?? '',
                'Location' => $requestData['Location'] ?? '',
                'PTWNumber' => $requestData['PTWNumber'] ?? '',
                'ActivityDesc' => $requestData['ActivityDesc'] ?? '',
                'LSRCat' => $requestData['LSRCat'] ?? null,
                'WorkerVerifierName' => $requestData['WorkerVerifierName'] ?? '',
                'WorkerVerifierEmail' => $requestData['WorkerVerifierEmail'] ?? '',
                'Functions' => $requestData['Functions'] ?? '',
                'Status' => 'need stage 2', // Default status for new submissions
                'Details' => $processedDetails, // Use processed details with mapped field
            ];

            // Add new data to existing data array
            $existingData[] = $newLsrData;

            // Save updated data back to file
            $filePath = $this->dataPath . 'lsr-data.json';
            $success = file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

            if ($success === false) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to save data',
                    'data' => [
                        'Status' => false,
                        'Message' => 'Failed to save data to file'
                    ]
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => [
                    'Status' => true,
                    'Message' => 'LSR submitted successfully',
                    'Id' => $newId,
                    'ProcessId' => $newProcessId
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error: ' . $e->getMessage(),
                'data' => [
                    'Status' => false,
                    'Message' => 'An error occurred while processing the request'
                ]
            ], 500);
        }
    }

    /**
     * Post LSR Verify (Development)
     *
     * @authenticated
     * @defaultParam
     *
     * @bodyParam Id integer required LSR Id. Example: 474
     * @bodyParam Current_User string Current user. Example: string
     * @bodyParam Current_UserEmail string Current user email. Example: string
     * @bodyParam Current_MSID string Current MSID. Example: string
     * @bodyParam Company string Company name. Example: string
     * @bodyParam BlockFunction string Block / Function. Example: string
     * @bodyParam AreaField string Area / Field. Example: string
     * @bodyParam Location string Location. Example: string
     * @bodyParam PTWNumber string PTW number. Example: string
     * @bodyParam ActivityDesc string Activity description. Example: string
     * @bodyParam LSRCat integer LSR Category id. Example: 4219
     * @bodyParam WorkerVerifierName string Worker verifier name. Example: string
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
    public function verify(Request $request): JsonResponse
    {
        try {
            // Get the request body data
            $requestData = $request->all();

            // Validate required fields
            if (!$requestData) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Request data is required',
                    'data' => [
                        'Status' => false,
                        'Message' => 'Request data is required'
                    ]
                ], 400);
            }

            // Validate that Id is provided for verification
            if (!isset($requestData['Id']) || empty($requestData['Id'])) {
                return response()->json([
                    'status' => 400,
                    'message' => 'LSR Id is required for verification',
                    'data' => [
                        'Status' => false,
                        'Message' => 'LSR Id is required for verification'
                    ]
                ], 400);
            }

            // Read existing data from lsr-data.json
            $existingData = $this->getJsonData('lsr-data.json');

            // Find the record to update by Id
            $recordIndex = null;
            $recordToUpdate = null;
            foreach ($existingData as $index => $item) {
                if (isset($item['Id']) && $item['Id'] == $requestData['Id']) {
                    $recordIndex = $index;
                    $recordToUpdate = $item;
                    break;
                }
            }

            // Check if record exists
            if ($recordToUpdate === null) {
                return response()->json([
                    'status' => 404,
                    'message' => 'LSR record not found',
                    'data' => [
                        'Status' => false,
                        'Message' => 'LSR record with Id ' . $requestData['Id'] . ' not found'
                    ]
                ], 404);
            }

            // Process Details array to map ChecklistWorker to ChecklistWorkerVerifier
            // and NonCompliancesDetail to NonCompliancesDetailVerifier
            $processedDetails = [];
            if (isset($requestData['Details']) && is_array($requestData['Details'])) {
                foreach ($requestData['Details'] as $detail) {
                    $processedDetail = $detail;

                    // Map ChecklistWorker to ChecklistWorkerVerifier
                    if (isset($detail['ChecklistWorker'])) {
                        $processedDetail['ChecklistWorkVerifier'] = $detail['ChecklistWorker'];
                    }

                    // Map NonCompliancesDetail to NonCompliancesDetailVerifier
                    if (isset($detail['NonCompliancesDetail'])) {
                        $processedDetail['NonCompliancesDetail2'] = $detail['NonCompliancesDetail'];
                    }

                    $processedDetails[] = $processedDetail;
                }
            }

            // Update the record with new data (similar structure to submit but for existing record)
            $updatedRecord = [
                'Id' => $recordToUpdate['Id'], // Keep existing Id
                'ProcessId' => $recordToUpdate['ProcessId'], // Keep existing ProcessId
                'CreationDate' => $recordToUpdate['CreationDate'], // Keep original creation date
                'Current_User' => $requestData['Current_User'] ?? $recordToUpdate['Current_User'] ?? '',
                'Current_UserEmail' => $requestData['Current_UserEmail'] ?? $recordToUpdate['Current_UserEmail'] ?? '',
                'Current_MSID' => $requestData['Current_MSID'] ?? $recordToUpdate['Current_MSID'] ?? '',
                'Company' => $requestData['Company'] ?? $recordToUpdate['Company'] ?? '',
                'BlockFunction' => $requestData['BlockFunction'] ?? $recordToUpdate['BlockFunction'] ?? '',
                'AreaField' => $requestData['AreaField'] ?? $recordToUpdate['AreaField'] ?? '',
                'Location' => $requestData['Location'] ?? $recordToUpdate['Location'] ?? '',
                'PTWNumber' => $requestData['PTWNumber'] ?? $recordToUpdate['PTWNumber'] ?? '',
                'ActivityDesc' => $requestData['ActivityDesc'] ?? $recordToUpdate['ActivityDesc'] ?? '',
                'LSRCat' => $requestData['LSRCat'] ?? $recordToUpdate['LSRCat'] ?? null,
                'WorkerVerifierName' => $requestData['WorkerVerifierName'] ?? $recordToUpdate['WorkerVerifierName'] ?? '',
                'WorkerVerifierEmail' => $requestData['WorkerVerifierEmail'] ?? $recordToUpdate['WorkerVerifierEmail'] ?? '',
                'Functions' => $requestData['Functions'] ?? $recordToUpdate['Functions'] ?? '',
                'Status' => 'verified stage 2', // Update status to verified
                'Details' => $processedDetails, // Use processed details with verifier mappings
            ];

            // Update the record in the array
            $existingData[$recordIndex] = $updatedRecord;

            // Save updated data back to file
            $filePath = $this->dataPath . 'lsr-data.json';
            $success = file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

            if ($success === false) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to save verification data',
                    'data' => [
                        'Status' => false,
                        'Message' => 'Failed to save verification data to file'
                    ]
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => [
                    'Status' => true,
                    'Message' => 'LSR verified successfully',
                    'Id' => $recordToUpdate['Id'],
                    'ProcessId' => $recordToUpdate['ProcessId']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error: ' . $e->getMessage(),
                'data' => [
                    'Status' => false,
                    'Message' => 'An error occurred while processing the verification request'
                ]
            ], 500);
        }
    }

    /**
     * Post LSR Route To Initiator (Development)
     *
     * @authenticated
     * @defaultParam
     *
     * @bodyParam Id integer required LSR Id. Example: 474
     * @bodyParam Current_User string Current user. Example: string
     * @bodyParam Current_UserEmail string Current user email. Example: string
     * @bodyParam Current_MSID string Current MSID. Example: string
     * @bodyParam Company string Company name. Example: string
     * @bodyParam BlockFunction string Block / Function. Example: string
     * @bodyParam AreaField string Area / Field. Example: string
     * @bodyParam Location string Location. Example: string
     * @bodyParam PTWNumber string PTW number. Example: string
     * @bodyParam ActivityDesc string Activity description. Example: string
     * @bodyParam LSRCat integer LSR Category id. Example: 4219
     * @bodyParam WorkerVerifierName string Worker verifier name. Example: string
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
    public function routeToInitiator(Request $request): JsonResponse
    {
        try {
            // Get the request body data
            $requestData = $request->all();

            // Validate required fields
            if (!$requestData) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Request data is required',
                    'data' => [
                        'Status' => false,
                        'Message' => 'Request data is required'
                    ]
                ], 400);
            }

            // Validate that Id is provided
            if (!isset($requestData['Id']) || empty($requestData['Id'])) {
                return response()->json([
                    'status' => 400,
                    'message' => 'LSR Id is required',
                    'data' => [
                        'Status' => false,
                        'Message' => 'LSR Id is required'
                    ]
                ], 400);
            }

            // Read existing data from lsr-data.json
            $existingData = $this->getJsonData('lsr-data.json');

            // Find the record to update by Id
            $recordIndex = null;
            $recordToUpdate = null;
            foreach ($existingData as $index => $item) {
                if (isset($item['Id']) && $item['Id'] == $requestData['Id']) {
                    $recordIndex = $index;
                    $recordToUpdate = $item;
                    break;
                }
            }

            // Check if record exists
            if ($recordToUpdate === null) {
                return response()->json([
                    'status' => 404,
                    'message' => 'LSR record not found',
                    'data' => [
                        'Status' => false,
                        'Message' => 'LSR record with Id ' . $requestData['Id'] . ' not found'
                    ]
                ], 404);
            }

            // Process Details array to map ChecklistWorker to ChecklistWorkerVerifier
            // and NonCompliancesDetail to NonCompliancesDetailVerifier
            $processedDetails = [];
            if (isset($requestData['Details']) && is_array($requestData['Details'])) {
                foreach ($requestData['Details'] as $detail) {
                    $processedDetail = $detail;

                    // Map ChecklistWorker to ChecklistWorkerVerifier
                    if (isset($detail['ChecklistWorker'])) {
                        $processedDetail['ChecklistWorkVerifier'] = $detail['ChecklistWorker'];
                    }

                    // Map NonCompliancesDetail to NonCompliancesDetailVerifier
                    if (isset($detail['NonCompliancesDetail'])) {
                        $processedDetail['NonCompliancesDetail2'] = $detail['NonCompliancesDetail'];
                    }

                    $processedDetails[] = $processedDetail;
                }
            }

            // Update the record with new data (similar structure to submit but for existing record)
            $updatedRecord = [
                'Id' => $recordToUpdate['Id'], // Keep existing Id
                'ProcessId' => $recordToUpdate['ProcessId'], // Keep existing ProcessId
                'CreationDate' => $recordToUpdate['CreationDate'], // Keep original creation date
                'Current_User' => $requestData['Current_User'] ?? $recordToUpdate['Current_User'] ?? '',
                'Current_UserEmail' => $requestData['Current_UserEmail'] ?? $recordToUpdate['Current_UserEmail'] ?? '',
                'Current_MSID' => $requestData['Current_MSID'] ?? $recordToUpdate['Current_MSID'] ?? '',
                'Company' => $requestData['Company'] ?? $recordToUpdate['Company'] ?? '',
                'BlockFunction' => $requestData['BlockFunction'] ?? $recordToUpdate['BlockFunction'] ?? '',
                'AreaField' => $requestData['AreaField'] ?? $recordToUpdate['AreaField'] ?? '',
                'Location' => $requestData['Location'] ?? $recordToUpdate['Location'] ?? '',
                'PTWNumber' => $requestData['PTWNumber'] ?? $recordToUpdate['PTWNumber'] ?? '',
                'ActivityDesc' => $requestData['ActivityDesc'] ?? $recordToUpdate['ActivityDesc'] ?? '',
                'LSRCat' => $requestData['LSRCat'] ?? $recordToUpdate['LSRCat'] ?? null,
                'WorkerVerifierName' => $requestData['WorkerVerifierName'] ?? $recordToUpdate['WorkerVerifierName'] ?? '',
                'WorkerVerifierEmail' => $requestData['WorkerVerifierEmail'] ?? $recordToUpdate['WorkerVerifierEmail'] ?? '',
                'Functions' => $requestData['Functions'] ?? $recordToUpdate['Functions'] ?? '',
                'Status' => 'not comply stage 2', // Update status to not comply stage 2
                'Details' => $processedDetails, // Use processed details with verifier mappings
            ];

            // Update the record in the array
            $existingData[$recordIndex] = $updatedRecord;

            // Save updated data back to file
            $filePath = $this->dataPath . 'lsr-data.json';
            $success = file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

            if ($success === false) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to save data',
                    'data' => [
                        'Status' => false,
                        'Message' => 'Failed to save data to file'
                    ]
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => [
                    'Status' => true,
                    'Message' => 'LSR routed to initiator successfully',
                    'Id' => $recordToUpdate['Id'],
                    'ProcessId' => $recordToUpdate['ProcessId']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error: ' . $e->getMessage(),
                'data' => [
                    'Status' => false,
                    'Message' => 'An error occurred while processing the request'
                ]
            ], 500);
        }
    }

    /**
     * Get JSON data from file
     */
    private function getJsonData(string $filename): array
    {
        $filePath = $this->dataPath . $filename;

        if (!file_exists($filePath)) {
            return [];
        }

        $jsonContent = file_get_contents($filePath);
        return json_decode($jsonContent, true) ?? [];
    }
}
