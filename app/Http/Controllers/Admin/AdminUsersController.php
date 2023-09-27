<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use App\Services\UsersService;
use App\Models\Settings;

class AdminUsersController extends AdminController
{
    protected $routePath = "admin.users";
    protected $pageTitle = "Users";
    protected $resourcePath = "admin.users";
    protected $moduleService = UsersService::class;
    protected $filter = true;
    protected $add = false;

    protected $tableColumns = [
        ["label" => "Workforce", "name" => "workforce"],
        ["label" => "Account", "name" => "email"],
        ["label" => "Identify Provider", "name" => "identify_provider"],
        ["label" => "Pts Id", "name" => "pts_id"],
        ["label" => "Last Login", "name" => "last_login"],
        ["label" => "Days Since Login", "name" => ""],
        ["label" => "Status", "name" => "status"],
        
    ];

    protected $rules = [
        "email" => "required|min:3|max:150",
        "workforce" => "required|min:3|max:150",
        "identify_provider" => "required|min:3|max:150",
        "pts_id" => "required|min:3|max:150",
        "last_login" => "required|min:3|max:150",
        "status" => "required|min:3|max:150",
    ];
    public function create(Request $request)
    {
        $settings = Settings::all();

        return parent::create($request)->with('settings', $settings);
    }
    
}
