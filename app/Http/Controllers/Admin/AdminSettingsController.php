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
        $appVersions = AppVersion::join(AppVersion::raw('
            (SELECT app, MAX(created_at) as max_created
            FROM app_versions
            GROUP BY app) as latest
        '), function ($join) {
            $join->on('app_versions.app', '=', 'latest.app')
                ->on('app_versions.created_at', '=', 'latest.max_created');
        })
        ->select('app_versions.*')
        ->get();
        return view('admin.settings.index' , [
            'min_active_day'=> $minActiveDay?->value,
            "app_versions" => $appVersions
        ]);
    }
    
    public function storeAppVersion(Request $request){
        $exist = AppVersion::where('app', $request->app)->first();

        $props = [
            'android_version' => $request->android_version,
            'ios_version' => $request->ios_version,
            'download_url' => $request->download_url,
            'text_template' => $request->text_template,
            'popup_title' => $request->popup_title,
            'button_text' =>  $request->button_text,
            'app' => $request->app
        ];
        if($exist){
            $exist->update($props);
        }else{
            AppVersion::create($props);
        }
        return back()->with(['success' => 'Application setting berhasil diperbarui']);
    }
}
