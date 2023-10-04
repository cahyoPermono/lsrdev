<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use App\Services\AppModulesService;
use App\Models\AppModules;

class AdminAppModulesController extends AdminController
{
    protected $routePath = "admin.modules";
    protected $pageTitle = "App Modules";
    protected $resourcePath = "admin.modules";
    protected $moduleService = AppModulesService::class;


    protected $tableColumns = [
        ["label" => "Name", "name" => "name"],["label" => "Icon", "name" => "icon"],
        ["label" => "Key", "name" => "key"],
    ];

    protected $rules = [
        "name" => "required|min:3|max:150",
        "key" => "required|min:3|max:150",
    ];
    public function index(Request $request)
    {
        $data = AppModules::all();
    
        return view('admin.modules.table', [
            'data' => $data
        ]);
    }

    
}
