<?php
namespace App\Http\Controllers\Api\Itrac;

use App\Constanta\Constanta;
use Illuminate\Http\Request;
use App\Services\ITrac\ITracUtilityService;
use Laililmahfud\Adminportal\Controllers\ApiController;

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
      * @pathParam person_id string required
      * 
      * 
      * @response {
      *    "status": 200,
      *    "message": "success",
      *    "data": true
      *   }
      */
      public function personRequirement(Request $request,ITracUtilityService $iTracUtilityService,$personId){
          $result = $iTracUtilityService->checkRequirementPerson($personId);
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
      *              "name": "Halim Perdana K."
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
}