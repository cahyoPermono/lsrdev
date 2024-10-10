<?php
namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use App\Constanta\Constanta;
use Illuminate\Http\Request;
use App\Services\SettingsService;
use Laililmahfud\Adminportal\Controllers\AdminController;

class AdminSettingsController extends AdminController
{
    
    protected $routePath = "admin.settings";
    protected $pageTitle = "Settings";
    protected $moduleService = SettingsService::class;


    public function index(Request $request){
        $minActiveDay = Settings::where('key', Constanta::SETTING::MIN_ACTIVE_DAY)->first();
        return view('admin.settings.index' , [
            'min_active_day'=> $minActiveDay?->value
        ]);
    }
    
}
