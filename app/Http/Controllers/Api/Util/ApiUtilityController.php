<?php

namespace App\Http\Controllers\Api\Util;

use App\Services\Utility\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Utility\TodoTaskService;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Utility
 */
class ApiUtilityController extends ApiController
{
    /**
     * Todo List
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "total_task": 13,
     *       "tasks": [
     *       {
     *           "title": "OIM Approval",
     *           "description": "You have 13 OIM Approval tasks",
     *           "module_key": "oim_approval"
     *       }
     *       ]
     *   }
     *   }
     * 
     **/
    public function todo(Request $request,TodoTaskService $todoTaskService){
        $email = $this->auth()->email;
        $tasks = $todoTaskService->findAllTask($email);
        return $this->sendSuccess($tasks);
    }

    /**
     * App Version
     * 
     * @authenticated
     * @defaultParam
     * 
     * @response {
     *   "status": 200,
     *   "message": "success",
     *   "data": {
     *       "android_version": "0.3.11",
     *       "ios_version": "0.3.11",
     *       "download_url": "https://drive.google.com/",
     *       "text_template": "SmartX version 1.4.511 is now available! Go to the download page to get the latest version"
     *   }
     * }
     * 
     **/
    public function appVersion(Request $request,UtilityService $utilityService){
        $regid = $request->header('regid');
        $regid = explode('_', $regid);
        $appBundleId = $regid[0] ?? '';
        if ($appBundleId == "com.medco.dashboardmanagement" || $appBundleId == "com.medcoenergi.productiondashboard"){
            $app = "production_dashboard";
        } else {
            $app = "smartx";
        }
        $appVersion = $utilityService->findAppVersion($app);
        return $this->sendSuccess($appVersion);
    }
}
