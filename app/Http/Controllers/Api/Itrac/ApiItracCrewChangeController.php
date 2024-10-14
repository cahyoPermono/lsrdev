<?php

namespace App\Http\Controllers\Api\Itrac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laililmahfud\Adminportal\Controllers\ApiController;
use App\Actions\Itrac\CrewChange\CreateCrewChangeAction;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use App\Http\Requests\Api\CrewChange\CreateCrewChangeRequest;

/**
 * @group ITrac/Crew Change
 */
class ApiItracCrewChangeController extends ApiController
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
     * @bodyParam return_date date required format Y-m-d (2024-10-14)
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
    public function store(CreateCrewChangeRequest $request,CreateCrewChangeAction $createCrewChangeAction){
        try{
            $user = $this->auth();
            $createCrewChangeAction->handle($request,$user); 
            return $this->sendMessage('Request submitted successfully');
        }catch(BadRequestException $e){
            return $this->badRequest($e->getMessage());
        }
    }
}
