<?php

namespace App\Http\Controllers\Api\Itrac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Itrac\CreatePoolCarAction;
use App\Actions\Itrac\CreateCrewChangeAction;
use App\Actions\Itrac\CreateSpecialTripAction;
use Laililmahfud\Adminportal\Controllers\ApiController;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use App\Http\Requests\Api\CrewChange\CreatePoolCarRequest;
use App\Http\Requests\Api\CrewChange\CreateCrewChangeRequest;
use App\Http\Requests\Api\CrewChange\CreateSpecialTripRequest;

/**
 * @group ITrac
 */
class ApiItracController extends ApiController
{
    /**
     * Create Crew Change
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam pts_id number required 
     * @bodyParam pts_company_id number required 
     * @bodyParam departure_date date required format Y-m-d (2024-10-14)
     * @bodyParam return_date date optional format Y-m-d (2024-10-14)
     * @bodyParam purpose_of_visit_id number required
     * @bodyParam coast_center_id number required
     * @bodyParam position_id number required
     * @bodyParam status string required
     * @bodyParam schedule string required
     * @bodyParam from_location_id number required
     * @bodyParam to_location_id number required
     * @bodyParam to_location_field_site_id number required
     * @bodyParam transit_point string required
     * @bodyParam accomodation boolean optional
     * 
     * @response {
     *   "status": 200,
     *   "message": "Request submitted successfully"
     * }
     * 
     * @response 400 {
     *   "status": 400,
     *   "error": "bad_request",
     *   "message": "An internal server error occured while processing the request"
     *  }
     */
    public function storeCreawChange(CreateCrewChangeRequest $request, CreateCrewChangeAction $createCrewChangeAction)
    {
        try {
            $user = $this->auth();
            $createCrewChangeAction->handle($request, $user);
            return $this->sendMessage('Request submitted successfully');
        } catch (BadRequestException $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * Create Special Trip
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam pts_id number required 
     * @bodyParam pts_company_id number required 
     * @bodyParam subject_request string required  in : <code>special_trip</code> atau <code>late_crew_change</code>
     * @bodyParam departure_date date required format Y-m-d (2024-10-14)
     * @bodyParam return_date date optional format Y-m-d (2024-10-14)
     * @bodyParam purpose_of_visit_id number required
     * @bodyParam coast_center_id number required
     * @bodyParam position_id number required
     * @bodyParam status string optional required if subject_request = late_crew_change
     * @bodyParam schedule string optional required if subject_request = late_crew_change
     * @bodyParam from_location_id number required
     * @bodyParam to_location_id number required
     * @bodyParam to_location_field_site_id number required
     * @bodyParam transit_point string required
     * @bodyParam accomodation boolean optional
     * @bodyParam oim_approver_id string required
     * @bodyParam oim_approver_email string required
     * @bodyParam justification  string required
     *
     * @response {
     *   "status": 200,
     *   "message": "Request submitted successfully"
     * }
     * 
     * @response 400 {
     *   "status": 400,
     *   "error": "bad_request",
     *   "message": "An internal server error occured while processing the request"
     *  }
     */
    public function storeSpecialTrip(CreateSpecialTripRequest $request, CreateSpecialTripAction $createSpecialTripAction)
    {
        try {
            $user = $this->auth();
            $createSpecialTripAction->handle($request, $user);
            return $this->sendMessage('Request submitted successfully');
        } catch (BadRequestException $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * 
     * Create Pool Car
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam pts_id number required 
     * @bodyParam date_time string required  format Y-m-d H:i:s
     * @bodyParam from_location_id number required
     * @bodyParam to_location_id number required
     * @bodyParam transportation_type_id nymber required
     * @bodyParam justification  string required
     *
     * @response {
     *   "status": 200,
     *   "message": "Request submitted successfully"
     * }
     * 
     * @response 400 {
     *   "status": 400,
     *   "error": "bad_request",
     *   "message": "An internal server error occured while processing the request"
     *  }
     */
    public function storePoolCar(CreatePoolCarRequest $request, CreatePoolCarAction $createPoolCarAction)
    {
        try {
            $user = $this->auth();
            $createPoolCarAction->handle($request, $user);
            return $this->sendMessage('Request submitted successfully');
        } catch (BadRequestException $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
