<?php

use App\Http\Controllers\Api\Itrac\ApiItracController;
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
use App\Http\Controllers\Api\Lsr\ApiLsrController;

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
                Route::get('/authorization', 'authorization')->name('authorization');
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
                Route::get('/competency', 'competency')->name('competency');
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
                Route::get('/competency', 'competency')->name('competency');
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
                        Route::get('/summary/production-breakdown', 'productionBreakdown')->name('summary-production-breakdown');
                        Route::get('/chart/gas', 'gasChart')->name('chart-gas');
                        Route::get('/chart/oil', 'oilChart')->name('chart-oil');
                        Route::get('/data/production', 'productionData')->name('data-production');
                        Route::get('/data/sales', 'salesData')->name('data-sales');
                        Route::get('/data/productionVsBudgetData', 'productionVsBudgetData')->name('data-production-vs-budget');
                        Route::get('/data/quarterlyProduction', 'quarterlyProductionData')->name('data-quarterly-production');
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
                        Route::get('/oim', 'reservationOim')->name('reservation-oim')->middleware(['authorization:oim_approval']);
                        Route::get('/oim-approver', 'oimApprover')->name('oim-approver');
                        Route::get('/{reservation_id}', 'show')->name('show');
                        Route::post('/oim-approver', 'updateOimApprover')->name('oim-approver.update');
                        Route::post('/approve-reject', 'approveReject')->name('approve-reject');
                        Route::post('/cancel/{reservation_id}', 'cancelReservation')->name('cancel-reservation');
                    });
                Route::controller(ApiItracUtilityController::class)
                    ->prefix('utility/')
                    ->as('utility.')
                    ->group(function () {
                        Route::get('/purpose-visit', 'purposeVisit')->name('purpose-visit');
                        Route::get('/location', 'location')->name('location');
                        Route::get('/status', 'status')->name('status');
                        Route::get('/transportation-type', 'transportationType')->name('transportation-type');
                        Route::get('/crew-change-schedule', 'crewChangeSchedule')->name('crew-change-schedule');
                        Route::get('/transit-point', 'transitPoint')->name('transit-point');
                        Route::get('/position', 'position')->name('position');
                        Route::get('/cost-center', 'costCenter')->name('cost-center');
                        Route::get('/requirement', 'personRequirement')->name('person-requirement');
                        Route::get('/personnel-category', 'personnelCategory')->name('personnel-category');
                        Route::get('/home-base', 'homeBase')->name('home-base');
                        Route::get('/department', 'department')->name('department');
                        Route::get('/flight-status', 'flightStatus')->name('flight-status');
                        Route::get('/company','company')->name('company');
                        Route::get('/intersite-schedule', 'intersiteSchedule')->name('intersite-schedule');
                    });
                Route::controller(ApiItracController::class)
                    ->group(function () {
                        Route::post('/store/crew-change', 'storeCrewChange')->name('store.crew-change')->middleware(['authorization:crew_change']);
                        Route::post('/store/special-trip', 'storeSpecialTrip')->name('store.special-trip')->middleware(['authorization:special_trip']);
                        Route::post('/store/pool-car', 'storePoolCar')->name('store.pool-car')->middleware(['authorization:pool_car']);
			            Route::post('/store/intersite', 'storeIntersite')->name('store.intersite')->middleware(['authorization:intersite']);
                    });
            });

        Route::prefix('lsr')
            ->as('lsr.')
            ->middleware(['authorization:lsr'])
            ->group(function () {
                Route::get('/companies', [ApiLsrController::class, 'companies'])->name('companies');
                Route::get('/blocks', [ApiLsrController::class, 'blocks'])->name('blocks');
                Route::get('/areas', [ApiLsrController::class, 'areas'])->name('areas');
                Route::get('/locations', [ApiLsrController::class, 'locations'])->name('locations');
                Route::get('/functions', [ApiLsrController::class, 'functions'])->name('functions');
                Route::get('/categories', [ApiLsrController::class, 'categories'])->name('categories');
                Route::get('/work-verifiers', [ApiLsrController::class, 'workVerifiers'])->name('work-verifiers');
                Route::get('/questionnaires', [ApiLsrController::class, 'questionnaires'])->name('questionnaires');
                Route::get('/submissions', [ApiLsrController::class, 'submissions'])->name('submissions');
                Route::post('/submissions', [ApiLsrController::class, 'storeSubmission'])->name('submissions.store');
                Route::post('/submissions/{submission_id}', [ApiLsrController::class, 'updateSubmission'])->name('submissions.update');
                Route::post('/submissions/{submission_id}/status', [ApiLsrController::class, 'updateSubmissionStatus'])->name('submissions.status.update');
            });
    });

/*
|--------------------------------------------------------------------------
| Development Routes (Testing Only) - Direct Access
|--------------------------------------------------------------------------
|
| Routes khusus untuk development dan testing API LSR.
| LANGSUNG akses data dummy tanpa autentikasi sama sekali.
| HANYA aktif di environment local/development.
| GUNAKAN HANYA untuk testing, JANGAN di production!
|
*/

// if (app()->environment(['local', 'development'])) {
    Route::prefix('dev/lsr')
        ->name('dev.lsr.')
        ->group(function () {

            // Companies
            Route::get('/companies', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/companies.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Companies data loaded',
                    'data' => $data
                ]);
            });

            // Areas
            Route::get('/areas', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/areas.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Areas data loaded',
                    'data' => $data
                ]);
            });

            // Blocks
            Route::get('/blocks', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/blocks.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Blocks data loaded',
                    'data' => $data
                ]);
            });

            // Locations
            Route::get('/locations', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/locations.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Locations data loaded',
                    'data' => $data
                ]);
            });

            // Functions
            Route::get('/functions', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/functions.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Functions data loaded',
                    'data' => $data
                ]);
            });

            // Categories
            Route::get('/categories', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/categories.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Categories data loaded',
                    'data' => $data
                ]);
            });

            // Work Verifiers
            Route::get('/work-verifiers', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/work-verifiers.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Work verifiers data loaded',
                    'data' => $data
                ]);
            });

            // Questionnaires
            Route::get('/questionnaires', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/questionnaires.json')), true);

                // Apply optional filters
                if (request()->has('stage')) {
                    $stage = request()->get('stage');
                    $data = array_filter($data, function($q) use ($stage) {
                        return $q['stage'] === $stage;
                    });
                }

                if (request()->has('category')) {
                    $category = request()->get('category');
                    $data = array_filter($data, function($q) use ($category) {
                        return $q['category'] === $category;
                    });
                }

                if (request()->has('required')) {
                    $required = request()->get('required') === 'true';
                    $data = array_filter($data, function($q) use ($required) {
                        return $q['required'] === $required;
                    });
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Questionnaires data loaded',
                    'data' => array_values($data)
                ]);
            });

            // Submissions
            Route::get('/submissions', function () {
                $data = json_decode(file_get_contents(storage_path('dummy-data/lsr/submissions.json')), true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Submissions data loaded',
                    'data' => $data
                ]);
            });

            // Create Submission (Development)
            Route::post('/submissions', function () {
                $requestData = request()->json()->all();

                // Validate required fields
                $requiredFields = ['company', 'block', 'area_field', 'location', 'function', 'ptw_number', 'activity_description', 'categorys', 'start_work_verifier_id'];
                foreach ($requiredFields as $field) {
                    if (!isset($requestData[$field])) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Field '{$field}' is required",
                            'data' => null
                        ], 400);
                    }
                }

                $submissions = json_decode(file_get_contents(storage_path('dummy-data/lsr/submissions.json')), true);

                // Generate new ID
                $newId = count($submissions) > 0 ? max(array_column($submissions, 'id')) + 1 : 1;

                // Create new submission
                $newSubmission = [
                    'id' => $newId,
                    'user_id' => $requestData['user_id'] ?? 1,
                    'company_id' => $requestData['company'],
                    'block_id' => $requestData['block'],
                    'area_id' => $requestData['area_field'],
                    'location_id' => $requestData['location'],
                    'function_id' => $requestData['function'],
                    'ptw_number' => $requestData['ptw_number'],
                    'activity_description' => $requestData['activity_description'],
                    'categories' => $requestData['categorys'],
                    'start_work_verifier_id' => $requestData['start_work_verifier_id'],
                    'questionnaires' => $requestData['questionnaires'] ?? [],
                    'status' => 'need_stage_2',
                    'created_at' => now()->toISOString(),
                    'updated_at' => now()->toISOString()
                ];

                // Add to submissions array
                $submissions[] = $newSubmission;

                // Save back to file
                file_put_contents(storage_path('dummy-data/lsr/submissions.json'), json_encode($submissions, JSON_PRETTY_PRINT));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Submission created successfully',
                    'data' => $newSubmission
                ]);
            });

            // Update Submission (Development)
            Route::post('/submissions/{submission_id}', function ($submissionId) {
                $requestData = request()->json()->all();

                if (!isset($requestData['questionnaires']) || !is_array($requestData['questionnaires'])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Questionnaires array is required',
                        'data' => null
                    ], 400);
                }

                $submissions = json_decode(file_get_contents(storage_path('dummy-data/lsr/submissions.json')), true);

                $submissionIndex = null;
                foreach ($submissions as $index => $submission) {
                    if ($submission['id'] == $submissionId) {
                        $submissionIndex = $index;
                        break;
                    }
                }

                if ($submissionIndex === null) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Submission not found',
                        'data' => null
                    ], 404);
                }

                $submissions[$submissionIndex]['questionnaires'] = $requestData['questionnaires'];
                $submissions[$submissionIndex]['status'] = 'verified_stage_2';
                $submissions[$submissionIndex]['updated_at'] = now()->toISOString();

                file_put_contents(storage_path('dummy-data/lsr/submissions.json'), json_encode($submissions, JSON_PRETTY_PRINT));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Submission updated successfully',
                    'data' => $submissions[$submissionIndex]
                ]);
            });

            // Update Submission Status (Development)
            Route::post('/submissions/{submission_id}/status', function ($submissionId) {
                $requestData = request()->json()->all();

                $submissions = json_decode(file_get_contents(storage_path('dummy-data/lsr/submissions.json')), true);

                $submissionIndex = null;
                foreach ($submissions as $index => $submission) {
                    if ($submission['id'] == $submissionId) {
                        $submissionIndex = $index;
                        break;
                    }
                }

                if ($submissionIndex === null) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Submission not found',
                        'data' => null
                    ], 404);
                }

                $submissions[$submissionIndex]['status'] = 'not_comply_stage_2';
                $submissions[$submissionIndex]['not_comply_reason'] = $requestData['reason'] ?? null;
                $submissions[$submissionIndex]['updated_at'] = now()->toISOString();

                file_put_contents(storage_path('dummy-data/lsr/submissions.json'), json_encode($submissions, JSON_PRETTY_PRINT));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: Submission status updated to not_comply_stage_2',
                    'data' => $submissions[$submissionIndex]
                ]);
            });

            // All Data (kombinasi semua)
            Route::get('/all-data', function () {
                $data = [
                    'companies' => json_decode(file_get_contents(storage_path('dummy-data/lsr/companies.json')), true),
                    'blocks' => json_decode(file_get_contents(storage_path('dummy-data/lsr/blocks.json')), true),
                    'areas' => json_decode(file_get_contents(storage_path('dummy-data/lsr/areas.json')), true),
                    'locations' => json_decode(file_get_contents(storage_path('dummy-data/lsr/locations.json')), true),
                    'functions' => json_decode(file_get_contents(storage_path('dummy-data/lsr/functions.json')), true),
                    'categories' => json_decode(file_get_contents(storage_path('dummy-data/lsr/categories.json')), true),
                    'work_verifiers' => json_decode(file_get_contents(storage_path('dummy-data/lsr/work-verifiers.json')), true),
                    'questionnaires' => json_decode(file_get_contents(storage_path('dummy-data/lsr/questionnaires.json')), true),
                    'submissions' => json_decode(file_get_contents(storage_path('dummy-data/lsr/submissions.json')), true),
                ];

                return response()->json([
                    'status' => 'success',
                    'message' => 'Development: All LSR data loaded',
                    'data' => $data
                ]);
            });

            // Info endpoint
            Route::get('/info', function () {
                return response()->json([
                    'status' => 'success',
                    'message' => 'LSR Development API',
                    'endpoints' => [
                        'companies' => '/dev/lsr/companies',
                        'blocks' => '/dev/lsr/blocks',
                        'areas' => '/dev/lsr/areas',
                        'locations' => '/dev/lsr/locations',
                        'functions' => '/dev/lsr/functions',
                        'categories' => '/dev/lsr/categories',
                        'work_verifiers' => '/dev/lsr/work-verifiers',
                        'questionnaires' => '/dev/lsr/questionnaires',
                        'submissions' => '/dev/lsr/submissions',
                        'create_submission' => '/dev/lsr/submissions (POST)',
                        'update_submission' => '/dev/lsr/submissions/{id} (POST)',
                        'update_submission_status' => '/dev/lsr/submissions/{id}/status (POST)',
                        'all_data' => '/dev/lsr/all-data'
                    ],
                    'note' => 'HANYA untuk development environment'
                ]);
            });
        });
// }





Route::get('/key', function () {
    if (!config('app.debug') || config('app.env') != 'local')
        abort(404);
    return base64_encode(date('Y-m-d') . "|" . portalconfig('api.secret_key'));
});
