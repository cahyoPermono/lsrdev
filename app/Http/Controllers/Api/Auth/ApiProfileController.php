<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Auth\ProfileResource;
use App\Services\MedcoApi\MedcoUser;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Profile
 */
class ApiProfileController extends ApiController
{
    public function __construct(
        private MedcoUser $medcoUser
    ){}

    /**
     * Detail Profile
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "person_id": 19823818,
     *       "email": "abdul.hakim@contractor.medcoenergi.com",
     *       "first_name": "Abdul",
     *       "middle_name": "",
     *       "last_name": "HAKIM",
     *       "sex": "M",
     *       "nationality": "Indonesia",
     *       "department": "Information Technology",
     *       "company": "JASNIKOM GEMANUSA PT",
     *       "entity": ":TODO",
     *       "person_status": "A",
     *       "supervisor": "Ade  ANWAR",
     *       "qr_code": "https://chart.googleapis.com/chart?chl19823818&chs=500x500&cht=qr&chld=H%7C0"
     *   }
     * }
     */
    public function index(Request $request)
    {
        $person_id = $this->auth()->person_id;
        $user = $this->medcoUser->findUserByPersonId($person_id);
        abort_if(!$user,404);
        
        return $this->sendSuccess(new ProfileResource($user));
    }
}