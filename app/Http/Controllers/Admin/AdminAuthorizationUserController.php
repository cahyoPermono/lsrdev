<?php
namespace App\Http\Controllers\Admin;

use App\Models\AuthorizationUser;
use App\Services\Account\AuthorizationUserService;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController; 
use App\Models\AppModules;
use App\Imports\AuthorizationUserImport;

class AdminAuthorizationUserController extends AdminController
{
    protected $routePath = "admin.authorization-user";
    protected $pageTitle = "Authorization User";
    protected $resourcePath = "admin.authorization-user";
    protected $moduleService = AuthorizationUserService::class;

    protected $import = true;
    protected $importExcel = AuthorizationUserImport::class;

    protected $tableColumns = [
        ["label" => "Email", "name" => "email"],
        ["label" => "Select Modules", "name" => "modules_id"],
    ];

    protected $rules = [
        "email" => "required|min:3|max:150",
    ];


    public function create(Request $request)
    {
        $this->data = [
            "appModules" => AppModules::whereNull('parent_id')->with('sub')->orderBy('sorting', 'asc')->get(),
            "authorization" => []
        ];
        return parent::create($request);
    }

    public function edit(Request $request, $email)
    {
        $authorization = $this->moduleService()->findModuleIdByEmail($email)->toArray();
        $this->data = [
            "page_title" => $this->pageTitle,
            "route" => $this->routePath,
            "action" => route("{$this->routePath}.update", $email),
            "form_views" => "{$this->resourcePath}.create",
            "type" => "update",
            "email" => $email,
            "authorization" => $authorization,
            "appModules" => AppModules::whereNull('parent_id')->with('sub')->orderBy('sorting', 'asc')->get()
        ];

        return view("portal::default.form", $this->data);
    }

}