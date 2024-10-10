<?php

use App\Http\Controllers\Api\Itrac\ApiItracReservationController;
use App\Http\Controllers\Api\Itrac\ApiItracUtilityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\ApiUserController;
use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiProfileController;
use App\Http\Controllers\Api\Util\ApiUtilityController;
use App\Http\Controllers\Api\Hse\ApiUtilityHseController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2Controller;
use App\Http\Controllers\Api\Isolation\ApiIsolationController;
use App\Http\Controllers\Api\PwtIssuer\ApiPwtIssuerController;
use App\Http\Controllers\Api\Hse\ApiUtitilySafetyCardController;
use App\Http\Controllers\Api\Auth\ApiUserAuthorizationController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2BlockController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2FieldController;
use App\Http\Controllers\Api\UseCase2\ApiUseCase2AssetsController;
use App\Http\Controllers\Api\UseCase2\ApiUseCaseCompanyController;
use App\Http\Controllers\Api\SelfScreening\ApiSelfScreeningController;
use App\Http\Controllers\Api\OtherScreening\ApiOtherScreeningController;
use App\Http\Controllers\Api\SelfScreening\ApiSelfScreeningCertificateController;
use App\Http\Controllers\Api\OtherScreening\ApiOtherScreeningCertificateController;

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


        Route::get('/user/{person_id}/profile', ApiUserController::class)->name('user.profile');//->middleware(['authorization:other-screening']);

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
            ->middleware(['authorization:self-screening'])
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/pts', 'ptsCertificate')->name('pts-certificate');
            });

        Route::controller(ApiSelfScreeningController::class)
            ->prefix('self-screening')
            ->as('self-screening.')
            ->middleware(['authorization:self-screening'])
            ->group(function () {
                Route::get('/training', 'training')->name('training');
                Route::get('/competency', 'competency')->name('training');
            });

        Route::controller(ApiOtherScreeningCertificateController::class)
            ->prefix('other-screening/{person_id}/certificate')
            ->as('other-screening.certificate.')
            ->middleware(['authorization:other-screening'])
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/pts', 'ptsCertificate')->name('pts-certificate');
            });

        Route::controller(ApiOtherScreeningController::class)
            ->prefix('other-screening/{person_id}')
            ->as('other-screening.')
            ->middleware(['authorization:other-screening'])
            ->group(function () {
                Route::get('/profile', 'profile')->name('profile');
                Route::get('/training', 'training')->name('training');
                Route::get('/competency', 'competency')->name('training');
            });

        Route::controller(ApiIsolationController::class)
            ->prefix('isolation/{pid}')
            ->as('isolation.')
            ->middleware(['authorization:isolation'])
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/method/{type}', 'method')->name('method')->whereIn('type', ['process', 'automation', 'electrical', 'esd', 'positive']);
                Route::put('/method', 'updateMethod')->name('method.update');
            });
        Route::controller(ApiIsolationController::class)
            ->prefix('isolation')
            ->as('isolation.')
            ->middleware(['authorization:isolation'])
            ->group(function () {
                Route::get('/verificator/{ptsid}', 'verificator')->name('verificator');
            });

        Route::controller(ApiPwtIssuerController::class)
            ->prefix('ptw-issuer/{pid}')
            ->as('ptw-issuer.')
            ->middleware(['authorization:ptw-issuer'])
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{code}/wl', 'wlList')->name('wl-list');
                Route::put('/{code}/wl/update', 'updateWl')->name('wl-update');
            });



        Route::prefix('use-case-2')
            ->as('use-case-2.')
            ->middleware(['authorization:use-case-2'])
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


        Route::get('/hse/utility/slider', [ApiUtilityHseController::class, 'slider'])->name('hse.utility.slider');
        Route::prefix('hse')
            ->as('hse.')
            ->middleware(['authorization:hse'])
            ->group(function () {
                Route::controller(ApiUtilityHseController::class)
                    ->prefix('utility')
                    ->as('utility.')
                    ->group(function () {
                        Route::get('/new-data', 'newData')->name('new-data');
                        Route::get('/popup-campaign', 'popupCampaign')->name('popup-campaign');
                        Route::get('/event/upcoming', 'upcomingEvent')->name('upcoming-event');
                        Route::get('/events', 'events')->name('events');
                        Route::get('/documents', 'documents')->name('documents');
                        Route::get('/quizz', 'quizz')->name('quizz');
                        Route::get('/news', 'news')->name('news');
                        Route::get('/safety-poster', 'safetyPoster')->name('safety-poster');
                        Route::get('/leasson-learned', 'leassonLearned')->name('leasson-learned');
                    });
                Route::controller(ApiUtitilySafetyCardController::class)
                    ->prefix('safety-card')
                    ->as('safety-card.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/{id}/detail', 'detail')->name('detail');
                        Route::get('/statistic', 'statistic')->name('statistic');
                        Route::get('/risk-rank', 'riskRank')->name('risk-rank');
                        Route::get('/category', 'category')->name('category');
                        Route::get('/block-function', 'blockFunction')->name('block-function');
                        Route::get('/location', 'location')->name('location');
                        Route::get('/division', 'division')->name('division');
                        Route::get('/department', 'department')->name('department');
                        Route::get('/report-type', 'reportType')->name('report-type');
                        Route::get('/posibility-of-event', 'positibilyOfEvent')->name('posibility-of-event');
                        Route::get('/unsafe-behaviour', 'unsafeBehaviour')->name('unsafe-behaviour');
                        Route::get('/unsafe-condition', 'unsafeCondition')->name('unsafe-condition');
                        Route::get('/unsafe-reason', 'unsafeReason')->name('unsafe-reason');
                        Route::get('/life-saving-rules', 'lifeSavingRules')->name('life-saving-rules');
                        Route::get('/recomendation/category', 'recomendationCategory')->name('recomendation.category');
                        Route::get('/recomendation/priority', 'recomendationPriority')->name('recomendation.priority');
                        Route::get('/recomendation/position', 'recomendationPosition')->name('recomendation.position');
                        Route::get('/recomendation/responsibile', 'recomendationResponsibile')->name('recomendation.responsibile');
                        Route::post('/store', 'store')->name('store');
                        Route::get('/observation-location', 'observationLocation')->name('observation-location');
                    });
            });

        Route::controller(ApiUtilityController::class)
            ->prefix('utility/')
            ->as('utility.')
            ->group(function () {
                Route::get('/todo', 'todo')->name('todo');
                Route::get('/app-version', 'appVersion')->name('app-version');
            });

        Route::prefix('itrac/')
            ->as('itrac.')
            ->middleware(['authorization:itrac'])
            ->group(function () {
                Route::controller(ApiItracReservationController::class)
                    ->prefix('reservation/')
                    ->as('reservation.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/{reservation_id}', 'show')->name('show');
                        Route::get('/oim-approver', 'oimApprover')->name('oim-approver');
                    });
                Route::controller(ApiItracUtilityController::class)
                    ->prefix('utility/')
                    ->as('utility.')
                    ->group(function () {
                        Route::get('/status', 'status')->name('status');
                        Route::get('/schedule', 'schedule')->name('schedule');
                        Route::get('/transit-point', 'transitPoint')->name('transit-point');
                        Route::get('/position', 'position')->name('position');
                        Route::get('/cost-center', 'costCenter')->name('cost-center');
                        Route::get('/requirement/{person_id}', 'personRequirement')->name('person-requirement');
                    });
            });
    });

Route::get('/key', function () {
    if (!config('app.debug') || config('app.env') != 'local')
        abort(404);
    return base64_encode(date('Y-m-d') . "|" . portalconfig('api.secret_key'));
});
