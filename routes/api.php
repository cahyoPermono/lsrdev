<?php

use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiProfileController;
use App\Http\Controllers\Api\SelfScreening\ApiSelfScreeningCertificateController;
use App\Http\Controllers\Api\SelfScreening\ApiSelfScreeningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['portal-api'])
    ->group(function () {
        Route::post('/auth/login', ApiLoginController::class)->name('auth.login');
    });

Route::middleware(['private-api'])
    ->group(function () {

        Route::controller(ApiProfileController::class)
            ->prefix('profile')
            ->as('profile.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::delete('/logout', 'logout')->name('logout');
            });

        Route::controller(ApiSelfScreeningCertificateController::class)
            ->prefix('self-screening/certificate')
            ->as('self-screening.certificate.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/pts', 'ptsCertificate')->name('pts-certificate');
            });

        Route::controller(ApiSelfScreeningController::class)
            ->prefix('self-screening')
            ->as('self-screening.')
            ->group(function () {
                Route::get('/training', 'training')->name('training');
                Route::get('/competency', 'competency')->name('training');
            });

    });

Route::get('/key', function () {
    if (!config('app.debug') || config('app.env') != 'local')
        abort(404);
    return base64_encode(date('Y-m-d') . "|" . portalconfig('api.secret_key'));
});