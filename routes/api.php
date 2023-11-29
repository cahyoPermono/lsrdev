<?php

use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiProfileController;
use App\Http\Controllers\Api\Auth\ApiUserAuthorizationController;
use App\Http\Controllers\Api\Isolation\ApiIsolationController;
use App\Http\Controllers\Api\OtherScreening\ApiOtherScreeningCertificateController;
use App\Http\Controllers\Api\OtherScreening\ApiOtherScreeningController;
use App\Http\Controllers\Api\PwtIssuer\ApiPwtIssuerController;
use App\Http\Controllers\Api\SelfScreening\ApiSelfScreeningCertificateController;
use App\Http\Controllers\Api\SelfScreening\ApiSelfScreeningController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2AssetsController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2BlockController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2Controller;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2FieldController;
use App\Http\Controllers\Api\UseCase2\ApiUseCaseCompanyController;
use App\Http\Controllers\Api\User\ApiUserController;
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


        Route::get('/user/{person_id}/profile', ApiUserController::class)->name('user.profile');

        Route::controller(ApiUserAuthorizationController::class)
            ->prefix('auth/')
            ->as('auth.')
            ->group(function () {
                Route::get('/authorization', 'authorization')->name('logout');
                Route::delete('/logout', 'logout')->name('logout');
            });
        Route::controller(ApiProfileController::class)
            ->prefix('profile')
            ->as('profile.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
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

        Route::controller(ApiOtherScreeningCertificateController::class)
            ->prefix('other-screening/{person_id}/certificate')
            ->as('other-screening.certificate.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/pts', 'ptsCertificate')->name('pts-certificate');
            });

        Route::controller(ApiOtherScreeningController::class)
            ->prefix('other-screening/{person_id}')
            ->as('other-screening.')
            ->group(function () {
                Route::get('/profile', 'profile')->name('profile');
                Route::get('/training', 'training')->name('training');
                Route::get('/competency', 'competency')->name('training');
            });

        Route::controller(ApiIsolationController::class)
            ->prefix('isolation/{pid}')
            ->as('isolation.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/method/{type}', 'method')->name('method')->whereIn('type', ['process', 'automation', 'electrical', 'esd', 'positive']);
                Route::put('/method', 'updateMethod')->name('method.update');
            });
        Route::controller(ApiIsolationController::class)
            ->prefix('isolation')
            ->as('isolation.')
            ->group(function () {
                Route::get('/verificator/{ptsid}', 'verificator')->name('verificator');
            });

        Route::controller(ApiPwtIssuerController::class)
            ->prefix('ptw-issuer/{pid}')
            ->as('ptw-issuer.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{code}/wl', 'wlList')->name('wl-list');
                Route::put('/{code}/wl/update', 'updateWl')->name('wl-update');
            });



        Route::prefix('use-case-2')
            ->as('use-case-2.')
            ->group(function () {
                Route::get('/', [ApiUseCase2Controller::class, 'index'])->name('index');

                Route::controller(ApiUseCaseCompanyController::class)
                    ->prefix('main')
                    ->as('main.')
                    ->group(function () {
                        Route::get('/summary', 'summary')->name('summary-production');
                        Route::get('/chart/gas', 'gasChart')->name('chart-gas');
                        Route::get('/chart/oil', 'oilChart')->name('chart-oil');
                        Route::get('/data/production', 'productionData')->name('data-production');
                        Route::get('/data/sales', 'salesData')->name('data-sales');
                    });
                Route::controller(ApiUseCase2AssetsController::class)
                    ->prefix('assets/{code}')
                    ->as('assets.')
                    ->group(function () {
                        Route::get('/summary', 'summary')->name('summary-production');
                        Route::get('/chart/gas', 'gasChart')->name('chart-gas');
                        Route::get('/chart/oil', 'oilChart')->name('chart-oil');
                        Route::get('/data/production', 'productionData')->name('data-production');
                        Route::get('/data/sales', 'salesData')->name('data-sales');
                    });

                Route::controller(ApiUseCase2BlockController::class)
                    ->prefix('block/{code}')
                    ->as('block.')
                    ->group(function () {
                        Route::get('/summary', 'summary')->name('summary-production');
                        Route::get('/chart/gas', 'gasChart')->name('chart-gas');
                        Route::get('/chart/oil', 'oilChart')->name('chart-oil');
                        Route::get('/data/production', 'productionData')->name('data-production');
                        Route::get('/data/sales', 'salesData')->name('data-sales');
                    });

                Route::controller(ApiUseCase2FieldController::class)
                    ->prefix('field/{code}')
                    ->as('field.')
                    ->group(function () {
                        Route::get('/summary', 'summary')->name('summary-production');
                        Route::get('/chart/gas', 'gasChart')->name('chart-gas');
                        Route::get('/chart/oil', 'oilChart')->name('chart-oil');
                        Route::get('/data/production', 'productionData')->name('data-production');
                        Route::get('/data/sales', 'salesData')->name('data-sales');
                    });
            });




    });

Route::get('/key', function () {
    if (!config('app.debug') || config('app.env') != 'local')
        abort(404);
    return base64_encode(date('Y-m-d') . "|" . portalconfig('api.secret_key'));
});
