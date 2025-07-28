<?php
namespace App\Http\Controllers\Api\Itrac;

use App\Constanta\Constanta;
use Illuminate\Http\Request;
use App\Services\ITrac\ITracUtilityService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @group ITrac/Utility
 */
class ApiItracUtilityController extends ApiController
{

    /**
     * Position
    * 
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *     "status": 200,
    *     "message": "success",
    *     "data": [
    *          {
    *               "id": 12,
    *               "code": "ALAPAP",
    *               "name": "Alfalaval Appli"
    *          }
    *     ]
    * }
    */
    public function position(Request $request, ITracUtilityService $iTracUtilityService)
    {
        $result = $iTracUtilityService->findAllPosition();
        return $this->sendSuccess($result);
    }

    /**
     * Cost Center
    * 
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *     "status": 200,
    *     "message": "success",
    *     "data": [
    *          {
    *               "id": 12,
    *               "code": "WIB.009.1205",
    *               "name": "WIB.009.1205"
    *          }
    *     ]
    * }
    */
    public function costCenter(Request $request, ITracUtilityService $iTracUtilityService)
    {
        $result = $iTracUtilityService->findAllCostCenter();
        return $this->sendSuccess($result);
    }

/**
     * Person Requirement Validation
    * 
    * @authenticated
    * @defaultParam
    * 
    * @queryParam person_id string required 
    * @queryParam position_code string required 
    * @queryParam departure_date string required
    * @queryParam status string optional
    * 
    * @response {
    * "status": 200,
    * "message": "success",
    * "data": {
    *     "is_valid": true,
    *     "competencies": [
    *     {
    *         "name": "HSE Orientation",
    *         "certificates": [
    *         {
    *             "code": "1-HSEORI",
    *             "name": "HSE Orientation",
    *             "expire_date": "2025-09-15",
    *             "status": "Valid"
    *         }
    *         ]
    *     },
    *     {
    *         "name": "Medical Check Up",
    *         "certificates": [
    *         {
    *             "code": "2-MCU",
    *             "name": "Medical Check Up",
    *             "expire_date": "2024-09-15",
    *             "status": "Invalid"
    *         },
    *         {
    *             "code": "2-TMPFIT",
    *             "name": "Temporary Fit",
    *             "competency": "Medical Check Up",
    *             "expire_date": null,
    *             "status": "Not Found"
    *         }
    *         ]
    *     }
    *     ]
    * }
    * }
    */
    public function personRequirement(Request $request,ITracUtilityService $iTracUtilityService){
    $validatedData = $request->validate([
        'person_id' => 'required|string',
        'position_code' => 'required|string',
        'departure_date' => 'required|date',
        'status' => 'nullable|string', // status is optional
    ]);

    $personId = $validatedData['person_id'];
    $positionCode = $validatedData['position_code'];
    $departureDate = $validatedData['departure_date'];
    $status = $validatedData['status'] ?? 'default'; // optional
    
    try{
        $result = $iTracUtilityService->checkRequirementPerson(
            personId: $personId, 
            positionCode: $positionCode,
            departureDate: $departureDate,
            status: $status
        );
    }
    catch (BadRequestException $e){
        return $this->badRequest($e->getMessage());
    }

    catch (HttpException $e) {
        return response()->json([
            'status' => $e->getStatusCode(),
            'message' => $e->getMessage(),
        ], $e->getStatusCode());
    }
    Debugbar::info($result);
    return $this->sendSuccess($result);
    }

    /**
     * Status
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         "ON-DUTY",
    *         "OFF-DUTY"
    *    ]
    *    }
    */
    public function status(Request $request,ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->findUtilitySetting(Constanta::ITRAC_UTILITY::STATUS);
        return $this->sendSuccess($result);
    }

    /**
     * Crew Change Schedule
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         "Palembang 07:30",
    *         "Jambi 11:00",
    *         "Grissik 05:30",
    *         "Grissik 08:30",
    *         "Suban 05:30",
    *         "Dayung 05:30"
    *    ]
    *    }
    */
    public function crewChangeSchedule(Request $request, ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->findUtilitySetting(Constanta::ITRAC_UTILITY::CREW_CHANGE_SCHEDULE);
        return $this->sendSuccess($result);
    }

    /**
     * Transit Point
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         "Via Grissik",
    *         "Direct to Location "
    *    ]
    *    }
    */
    public function transitPoint(Request $request,ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->findUtilitySetting(Constanta::ITRAC_UTILITY::TRANSIT_POINT);
        return $this->sendSuccess($result);
    }

    /**
     * Location
    *
    * @authenticated       
    * @defaultParam
    *
    * @queryParam type string optional The type of location. Allowed values: "field_site", "terminal", or null.
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         {
    *              "id": 1,
    *              "code": "HLP",
    *              "name": "Halim Perdana K.",
    *              "field_site_id" : null,
    *              "terminal_id" : 1
    *         }
    *    ]
    *    }
    */
    public function location(Request $request, ITracUtilityService $iTracUtilityService)
    {
        $type = $request->input('type', null);
        if ($type !== null && !in_array($type, ['field_site', 'terminal'], true)) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid type parameter. Allowed values are "field_site", "terminal", or null.',
            ], 400);
        }
        
        $result = $iTracUtilityService->findAllLocation($type);
        return $this->sendSuccess($result);
    }


    /**
     * Purpose Of Visit
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         {
    *              "id": 10,
    *              "code": "PA",
    *              "name": "Planned Activity"
    *         }
    *    ]
    *    }
    */
    public function purposeVisit(Request $request,ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->findAllPurposeOfVisit();
        return $this->sendSuccess($result);
    }

    /**
     * Transportation Type
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         {
    *              "id": 10,
    *              "name": "Planned Activity"
    *         }
    *    ]
    *    }
    */
    public function transportationType(Request $request,ITracUtilityService $iTracUtilityService){
    $result = $iTracUtilityService->findAllTransportaionType();
    return $this->sendSuccess($result);
    }

    /**
        * Personnel Category
        *
        * @authenticated
        * @defaultParam
        * 
        * 
        * @response 
        * {
        * "status": 200,
        * "message": "success",
        * "data": [
        *    {
        *    "id": 1,
        *    "code": "foa",
        *    "name": "FOA",
        *    "days": [
        *        "Monday"
        *       ]
        *    },
        *    {
        *    "id": 2,
        *    "code": "contractor_non_foa",
        *    "name": "Contractor Non-FOA",
        *    "days": [
        *        "Tuesday",
        *        "Wednesday",
        *        "Thursday",
        *        "Friday"
        *       ]
        *    }
        *}
    */
    public function personnelCategory(Request $request, ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->getPersonnelCategories();
        return $this->sendSuccess($result);
    }
    /**
     * Home Base
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         "Lorem",
    *         "Ipsum"
    *    ]
    *    }
    */
    public function homeBase(Request $request, ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->findUtilitySetting(Constanta::ITRAC_UTILITY::HOME_BASE);
        return $this->sendSuccess($result);
    }

    /**
     * Department
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         "Lorem",
    *         "Ipsum"
    *    ]
    *    }
    */
    public function department(Request $request, ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->findUtilitySetting(Constanta::ITRAC_UTILITY::DEPARTMENT);
        return $this->sendSuccess($result);
    }

    /**
     * Flight Status
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         "Lorem",
    *         "Ipsum"
    *    ]
    *    }
    */
    public function flightStatus(Request $request, ITracUtilityService $iTracUtilityService): mixed{
        $result = $iTracUtilityService->findUtilitySetting(Constanta::ITRAC_UTILITY::FLIGHT_STATUS);
        return $this->sendSuccess($result);
    }

    /**
     * Company
    *
    * @authenticated
    * @defaultParam
    * 
    * 
    * @response {
    *    "status": 200,
    *    "message": "success",
    *    "data": [
    *         {
    *              "id": 6548,
    *              "code": "Kairos",
    *              "name": "KAIROS UTAMA INDONESIA PT"
    *         },
    *         {
    *              "id": 6045,
    *              "code": "MEPG",
    *              "name": "MEDCO E&P GRISSIK LTD"
    *         }
    *    ]
    *    }
    */
    public function company(Request $request, ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->getCompanies();
        return $this->sendSuccess($result);
    }

    /**
     * Intersite Schedules
     * 
     * Retrieve ITrac transport schedules with optional filters.
     * 
     * @authenticated
	 * @defaultParam
     * 
     * @queryParam from string Optional. Filter by departure location. Example: Grissik
     * @queryParam to string Optional. Filter by destination location. Example: Dayung
     * 
     * @response 200 {
     *   "status": 200,
     *   "data": [
     *     {
     *       "id": 1,
     *       "from_location": "Grissik",
     *       "to_location": "Gelam",
     *       "departure_time": "07:30:00",
     *       "created_at": "2025-07-03T06:45:00.000000Z",
     *       "updated_at": "2025-07-03T06:45:00.000000Z"
     *     },
     *     ...
     *   ]
     * }
     * 
     * @response 400 {
     *   "status": 400,
     *   "error": "bad_request",
     *   "message": "Bad Request"
     * }
     */
    public function intersiteSchedule(Request $request, ITracUtilityService $iTracUtilityService){
        $result = $iTracUtilityService->getIntersiteSchedules($request->from, $request->to);
        return $this->sendSuccess($result);
    }
}