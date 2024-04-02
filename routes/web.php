<?php

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUsersController;
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
    return view('welcome');
});
Route::group(['prefix' => portalconfig('admin_path'), 'as' => "admin.", 'middleware' => ['portal-admin']], function () {
    Route::post('/modules/sorting-menu', [AdminAppModulesController::class, 'sortingMenu'])->name('modules.sorting-menu');
    Route::post('/user/sync-status', [AdminUsersController::class, 'syncStatus'])->name('users.sync-status');

    Route::post('/authorization-user/import',[AdminAuthorizationUserController::class,'import'])->name('authorization-user.import');
});

Route::get('test-api-connection',function(){
    return MedcoRestful::fetchData(
        url : Url::ListCertificate,
        query : [
            "personid" => "4421118"
        ]
    );
});