<?php

namespace App\Http\Controllers\Api\Itrac;

use App\Http\Controllers\Controller;
use App\Services\ITrac\ITracReservationService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group ITrac/Reservation
 */
class ApiItracReservationController extends ApiController
{
    /**
     * Reservation List
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "id": 921444,
     *               "date": "2024-12-31",
     *               "title": "GELAM - DAYUNG",
     *               "description": "N/A | Need Approval",
     *               "person_id": "19823818",
     *               "type": "special_late_crew",
     *               "detail": null
     *           },
     *           {
     *               "id": 282477,
     *               "date": "2024-10-04",
     *               "title": "CGK - KGKKP",
     *               "description": "Pool Car",
     *               "person_id": 19823818,
     *               "type": "pool_car",
     *               "detail": {
     *                   "routing": "CGK - KGKKP",
     *                   "carrier_id": 282477,
     *                   "carrier_number": "-",
     *                   "departure_date": "2024-10-04",
     *                   "transportation_type": "LV-INNOVA",
     *                   "transportation_unit": "-",
     *                   "carrier_description": "Requested by:\rPTS ID: 19823818\rName: Abdul  HAKIM\rCompany: JASNIKOM GEMANUSA PT\rWork Location: Grissik\rJustification: \rTest",
     *                   "carrier_scheduled": "Unscheduled"
     *               }
     *           }
     *       ]
     *   }
     **/
    public function index(Request $request,ITracReservationService $iTracReservationService){
        $personId = $this->auth()->person_id;
        $result = $iTracReservationService->findAllReservation($personId);
        return $this->sendSuccess($result);
    }

    /**
     * OIM Approver Dropdown
     * 
     * @authenticated
     * @defaultParam
     * 
     * @queryParam work_location string required
     * 
     * @response {
     *       "status": 200,
     *       "message": "success",
     *       "data": [
     *           {
     *               "reservation_approver_id": 2,
     *               "person_id": 19821141,
     *               "name": "Ayu Annisa",
     *               "email": "ayu.annisa@tc.medcoenergi.com"
     *           }
     *       ]
     *   }
     */
    public function oimApprover(Request $request,ITracReservationService $iTracReservationService){
        $result = $iTracReservationService->findAllOimApprover($request->work_location);
        return $this->sendSuccess($result);
    }

    /**
     * Detail Reservation
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam reservation_id integer required
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "title": "GELAM - DAYUNG",
     *       "reservation_id": 921444,
     *       "reservation_status": "Created",
     *       "approved_status": null,
     *       "request_subject": "N/A",
     *       "departure_date": "2024-12-31",
     *       "return_date": null,
     *       "schedule": "0",
     *       "transit_point": "Direct to Location",
     *       "transportation_number": "ON_QUOTA_DRIL",
     *       "transportation_type": "BOEING-737",
     *       "transportation_unit": "-",
     *       "transportation_mode": "FIXEDWING",
     *       "seat_no": "-",
     *       "status": "Special Trip",
     *       "purpose_of_visit": "R",
     *       "priority": "Priority A",
     *       "accomodation_location": "DAYUNG",
     *       "justification": "Testing"
     *   }
     *   }
     */
    public function show(Request $request,ITracReservationService $iTracReservationService,$reservationId){
        $result = $iTracReservationService->findReservationInfo($reservationId);
        return $this->sendSuccess($result);
    }

}
