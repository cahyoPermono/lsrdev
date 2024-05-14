<?php
namespace App\Http\Controllers\Admin;

use App\Services\Account\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Laililmahfud\Adminportal\Controllers\AdminController;

class AdminUsersController extends AdminController
{
    protected $routePath = "admin.users";
    protected $pageTitle = "Users";
    protected $resourcePath = "admin.users";
    protected $moduleService = UserService::class;
    protected $bulkAction = false;
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


    public function syncStatus(Request $request)
    {
        Artisan::call('app:deactivate-inactive-users');
        return back()->with(['success' => 'Sync status berhasil dijalankan!']);
    }
}