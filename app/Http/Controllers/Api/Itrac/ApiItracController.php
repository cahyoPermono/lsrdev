<?php

namespace App\Http\Controllers\Api\Itrac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Itrac\CreatePoolCarAction;
use App\Actions\Itrac\CreateCrewChangeAction;
use App\Actions\Itrac\CreateSpecialTripAction;
use App\Actions\Itrac\CreateIntersiteAction;
use Laililmahfud\Adminportal\Controllers\ApiController;
use App\Http\Requests\Api\CrewChange\CreatePoolCarRequest;
use App\Http\Requests\Api\CrewChange\CreateCrewChangeRequest;
use App\Http\Requests\Api\CrewChange\CreateSpecialTripRequest;
use App\Http\Requests\Api\CrewChange\CreateIntersiteRequest;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @group ITrac/Store
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
     * @bodyParam position_id number required
     * @bodyParam home_base string required 
     * @bodyParam personnel_category_name string required
     * @bodyParam department_name string required
     * @bodyParam departure_date date required format Y-m-d (2024-10-14)
     * @bodyParam return_date date optional format Y-m-d (2024-10-14)
     * @bodyParam purpose_of_visit_id number required
     * @bodyParam schedule string required
     * @bodyParam status string required  
     * @bodyParam from_location_id number required
     * @bodyParam to_location_id number required
     * @bodyParam flight_status string required
     * @bodyParam justification string optional
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
    public function storeCrewChange(CreateCrewChangeRequest $request, CreateCrewChangeAction $createCrewChangeAction)
    {
        try {
            $user = $this->auth();
            $createCrewChangeAction->handle($request, $user);
            return $this->sendMessage('Request submitted successfully');
        } catch (BadRequestException $e) {
            return $this->badRequest($e->getMessage());
        } catch (HttpException $e) {
            return response()->json([
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
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
     * @bodyParam department_name string required // Mechanical, IT
     * @bodyParam position_id number required
     * @bodyParam departure_date date required format Y-m-d (2024-10-14)
     * @bodyParam return_date date optional format Y-m-d (2024-10-14)
     * @bodyParam purpose_of_visit_id number required
     * @bodyParam status string optional required if subject_request = late_crew_change
     * @bodyParam from_location_id number required
     * @bodyParam to_location_id number required
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
        } catch (HttpException $e) {
            return response()->json([
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
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
        } catch (HttpException $e) {
            return response()->json([
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * Create Intersite
     * 
     * @authenticated
     * @defaultParam
     * 
     * @requestBody multipart/form-data
     * @bodyParam pts_id number required 
     * @bodyParam pts_company_id number required 
     * @bodyParam department_name string required // Mechanical, IT
     * @bodyParam position_id number required
     * @bodyParam subject_request string required  in : <code>scheduled_intersite</code> atau <code>unscheduled_intersite</code>
     * @bodyParam departure_date_time string required format Y-m-d H:i:s (2024-10-14)
     * @bodyParam purpose_of_visit_id number required
     * @bodyParam status string optional required
     * @bodyParam schedule string optional required if subject_request = scheduled_intersite
     * @bodyParam from_location_id number required
     * @bodyParam to_location_id number required
     * @bodyParam approver_id string optional required if subject_request = unscheduled_intersite
     * @bodyParam approver_email string optional required if subject_request = unscheduled_intersite
     * @bodyParam justification string optional required if subject_request = unscheduled_intersite
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
    public function storeIntersite(CreateIntersiteRequest $request, CreateIntersiteAction $createIntersiteAction)
    {
       try {
           $user = $this->auth();
           $createIntersiteAction->handle($request, $user);
           return $this->sendMessage('Request submitted successfully');
       } catch (BadRequestException $e) {
           return $this->badRequest($e->getMessage());
       } catch (HttpException $e) {
           return response()->json([
               'status' => $e->getStatusCode(),
               'message' => $e->getMessage(),
           ], $e->getStatusCode());
       }
    }
}
