<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use App\Services\AuthorizationUserService;
use App\Models\AppModules;

class AdminAuthorizationUserController extends AdminController
{
    protected $routePath = "admin.authorization-user";
    protected $pageTitle = "Authorization User";
    protected $resourcePath = "admin.authorization-user";
    protected $moduleService = AuthorizationUserService::class;


    protected $tableColumns = [
        ["label" => "Email", "name" => "email"],["label" => "Select Modules", "name" => "modules_id"],
    ];

    protected $rules = [
        "email" => "required|min:3|max:150",
        "permissions" => "required"
    ];

    public function create(Request $request)
    {
        $appModules = AppModules::all(); // Mengambil semua data App Modules

        return parent::create($request)->with('appModules', $appModules);
    }
}
