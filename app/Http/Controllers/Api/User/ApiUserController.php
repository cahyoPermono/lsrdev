<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Auth\ProfileResource;
use App\Services\MedcoApi\MedcoUserService;
use Illuminate\Http\Request;

/**
 * @group User
 */
class ApiUserController extends Controller
{
    public function __construct(
        private MedcoUserService $medcoUserService
    ) {
    }
    /**
     * Profile User
     * 
     * @authenticated
     * @defaultParam
     * 
     * @pathParam person_id string required
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "person_id": 19821141,
     *       "email": "ayu.annisa@contractor.medcoenergi.com",
     *       "first_name": "Ayu",
     *       "middle_name": "",
     *       "last_name": "ANNISA",
     *       "sex": "F",
     *       "nationality": "Indonesia",
     *       "department": "Information Technology",
     *       "company": "ISTECH RESOURCES ASIA PT",
     *       "entity": ":TODO",
     *       "person_status": "A",
     *       "supervisor": "Ade  ANWAR",
     *       "qr_code": "https://chart.googleapis.com/chart?chl19821141&chs=500x500&cht=qr&chld=H%7C0"
     *   }
     *  }
     */
    public function __invoke(Request $request, $person_id)
    {
        $user = $this->medcoUserService->findUserByPersonId($person_id);
        abort_if(!$user, 404);

        return $this->sendSuccess(new ProfileResource($user));
    }
}