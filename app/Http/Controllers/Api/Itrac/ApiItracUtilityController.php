<?php
namespace App\Http\Controllers\Api\Itrac;

use App\Constanta\Constanta;
use Illuminate\Http\Request;
use App\Services\ITrac\ITracUtilityService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

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
      * @queryParam position string required 
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
            'position' => 'required|string',
            'departure_date' => 'required|date',
            'status' => 'nullable|string', // status is optional
        ]);

        $personId = $validatedData['person_id'];
        $position = $validatedData['position'];
        $departureDate = $validatedData['departure_date'];
        $status = $validatedData['status'] ?? 'default'; // optional
        
        try{
            $result = $iTracUtilityService->checkRequirementPerson(
                personId: $personId, 
                position: $position,
                departureDate: $departureDate,
                status: $status
            );
        }
        catch (HttpException $e) {
            return response()->json([
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], 400);
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
          $result = $iTracUtilityService->findUtilitySetting(Constanta::SETTING::ITRAC_STATUS);
          return $this->sendSuccess($result);
      }

     /**
      * Schedule
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
      public function schedule(Request $request,ITracUtilityService $iTracUtilityService){
          $result = $iTracUtilityService->findUtilitySetting(Constanta::SETTING::ITRAC_SCHEDULE);
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
          $result = $iTracUtilityService->findUtilitySetting(Constanta::SETTING::ITRAC_TRANSIT_POINT);
          return $this->sendSuccess($result);
      }

      /**
      * Location
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
      *              "id": 1,
      *              "code": "HLP",
      *              "name": "Halim Perdana K.",
      *              "field_site_id" : null
      *         }
      *    ]
      *    }
      */
      public function location(Request $request,ITracUtilityService $iTracUtilityService){
          $result = $iTracUtilityService->findAllLocation();
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
       * Transportaion Type
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
}