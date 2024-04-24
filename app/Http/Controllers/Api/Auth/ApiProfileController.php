<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\ApiLogoutAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Auth\ProfileResource;
use App\Models\Account\User;
use App\Services\MedcoApi\MedcoUserService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Profile
 * @sorting 2
 */
class ApiProfileController extends ApiController
{
    public function __construct(
        private MedcoUserService $medcoUserService
    ) {
    }

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
        $user_id = $this->auth()->session_id;
        $person_id = $this->auth()->person_id;
        $medcoUser = $this->medcoUserService->findUserByPersonId($person_id);
        $user = User::where('id', $user_id)->first();


        $spv = $medcoUser?->supervisor ?: null;
        if ($spv) {
            $spv = "{$spv->first_name} {$spv->middle_name} {$spv->last_name}";
        }
        return $this->sendSuccess([
            'person_id' => $medcoUser?->person_id ?: '',
            'email' => $user->email,
            'first_name' => $medcoUser?->first_name ?: '',
            'middle_name' => $medcoUser?->middle_name ?: '', 
            'last_name' => $medcoUser?->last_name ?: '',
            'sex' => $medcoUser?->sex ?: '',
            'nationality' => $medcoUser?->nationality ?: '',
            'department' => $medcoUser?->department_name ?: '',
            'company' => $medcoUser?->company_name ?: '',
            'entity' => ":TODO",
            'person_status' => $medcoUser?->person_status ?: '',
            'supervisor' => $spv,
            'qr_code' => $medcoUser ? "https://chart.googleapis.com/chart?chl={$medcoUser?->person_id}&chs=500x500&cht=qr&chld=H%7C0" : ''
        ]);
    }

}