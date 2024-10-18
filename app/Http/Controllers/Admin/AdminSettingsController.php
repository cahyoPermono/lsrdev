<?php
namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use App\Constanta\Constanta;
use App\Models\Util\AppVersion;
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
        $appVersion = AppVersion::latest()->first();
        return view('admin.settings.index' , [
            'min_active_day'=> $minActiveDay?->value,
            "app_version" => $appVersion
        ]);
    }
    
    public function storeAppVersion(Request $request){
        $exist = AppVersion::latest()->first();
        AppVersion::updateOrCreate(['id'=>$exist?->id],[
            'android_version' => $request->android_version,
            'ios_version' => $request->ios_version,
            'download_url' => $request->download_url,
            'text_template' => $request->text_template,
        ]);
        return back()->with(['success' => 'Application setting berhasil diperbarui']);
    }
}
