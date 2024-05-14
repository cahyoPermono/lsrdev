<?php
namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use App\Services\SettingsService;

class AdminSettingsController extends AdminController
{
    
    protected $routePath = "admin.settings";
    protected $pageTitle = "Settings";
    protected $moduleService = SettingsService::class;


    public function index(Request $request){
        $min_active_day = Settings::where('key', 'min_active_day')->first();
        return view('admin.settings.index' , [
            'min_active_day'=> $min_active_day?->value
        ]);
    }
    
}
