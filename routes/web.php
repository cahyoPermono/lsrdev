<?php

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use Illuminate\Support\Facades\Route;
use App\Services\MedcoApi\MedcoUserService;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminAppModulesController;
use App\Http\Controllers\Admin\AdminAuthorizationUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return to_route('admin.dashboard');
});
Route::group(['prefix' => portalconfig('admin_path'), 'as' => "admin.", 'middleware' => ['portal-admin']], function () {
    Route::post('/modules/sorting-menu', [AdminAppModulesController::class, 'sortingMenu'])->name('modules.sorting-menu');
    Route::post('/user/sync-status', [AdminUsersController::class, 'syncStatus'])->name('users.sync-status');

    Route::post('/authorization-user/import',[AdminAuthorizationUserController::class,'import'])->name('authorization-user.import');
    Route::post('/admin.settings/app-version',[AdminSettingsController::class,'storeAppVersion'])->name('settings.app-version');
});

Route::get('test-api-connection',function(){
    return MedcoRestful::fetchData(
        url : Url::ListCertificate,
        query : [
            "personid" => "4421118"
        ]
    );
});