<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    SearchFunctionController,
    OverviewController,
    RegistrationController,
    QuartersController,
    TargetController,
    MunicipalityController,
    ClientDashboardController,
    AdminDashboardController,
    DavaoDeOroController,
    DavaoCityController,
    DavaoDelNorteController,
    DavaoDelSurController,
    DavaoOccidentalController,
    DavaoOrientalController,
    ExportController,
    UpdateSystemController
};

Route::get('/', [UpdateSystemController::class,'returnview']);

// Route::get('/getyears', [AdminDashboardController::class, 'getyears']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Routes accessible only to authenticated users
Route::middleware(['loggedin'])->group(function () {

    // routes for the client side
    Route::prefix('client')->middleware('clientroutes')->group(function () {
        Route::post('/editaccount', [ClientDashboardController::class, 'editaccount']);
        Route::post('/editpassword', [ClientDashboardController::class, 'editpassword']);
        Route::get('/accountsettings', [ClientDashboardController::class, 'getAccountSettingsPage']);
        Route::get('/dashboard', [ClientDashboardController::class, 'returnView']);
        Route::post('/submitreport', [ClientDashboardController::class, 'submitReport']);
        Route::get('/api/municipalities/{provinceId}', [MunicipalityController::class, 'getMunicipalities']);
        Route::get('/history', [ClientDashboardController::class, 'getReportHistoryPage']);
        Route::get('/get-report-details/{reportId}', [ClientDashboardController::class, 'getReportDetails']);
        Route::get('/variance', function () {
            return view('client.variance');
        });
        Route::post('/submitvariance', [ClientDashboardController::class, 'submitVariance']);
    });

    // routes for the admin side
    Route::prefix('admin')->middleware('adminroutes')->group(function () {
        // individual routes of the admin
        Route::post('/applytarget', [TargetController::class, 'updateTarget']);
        Route::post('/addTarget',[TargetController::class,'addTarget']);
        Route::get('/history', [AdminDashboardController::class, 'getReportHistoryPage']);
        Route::post('/search', [AdminDashboardController::class, 'quicksearch']);
        Route::get('/get-report-details/{reportId}', [AdminDashboardController::class, 'getReportDetails']);

        // Route::get('/get-report-details/{reportId}', [ClientDashboardController::class, 'getReportDetails']);
        Route::get('/target', [TargetController::class, 'returnview']);

        Route::get('/activequarters', function () {
            return view('admin.activequarters');
        });
        Route::get('/variance', function () {
            return view('admin.variance');
        });
        Route::get('/archives', function () {
            return view('admin.archives');
        });
        

        Route::get('getVariances', [AdminDashboardController::class, 'getVariances']);
        Route::get('/export', [ExportController::class, 'exportData']);
        Route::post('/editpassword', [AdminDashboardController::class, 'editpassword']);
        Route::post('/editaccount', [AdminDashboardController::class, 'editaccount']);
        Route::get('/accountsettings', [AdminDashboardController::class, 'getAccountSettingsPage']);
        // Route::get('/accountsettings', function () {
        //     return view('admin.accountsettings');
        // });

        Route::get('/quicksearch', function () {
            return view('admin.quicksearch');
        });

        // grouped routes of the admin
        Route::prefix('/dashboard')->group(function () {
            Route::get('/firstquarter', [AdminDashboardController::class, 'firstQuarter']);
            Route::get('/secondquarter', [AdminDashboardController::class, 'secondQuarter']);
            Route::get('/thirdquarter', [AdminDashboardController::class, 'thirdQuarter']);
            Route::get('/fourthquarter', [AdminDashboardController::class, 'fourthQuarter']);
            Route::get('/firstsemester', [AdminDashboardController::class, 'firstSemester']);
            Route::get('/secondsemester', [AdminDashboardController::class, 'secondSemester']);
        });

        // routes for the quarters of the admin
        Route::prefix('quarters')->group(function () {
            Route::post('/setfirstquarter', [QuartersController::class, 'firstquarter']);
            Route::post('/setsecondquarter', [QuartersController::class, 'secondquarter']);
            Route::post('/setthirdquarter', [QuartersController::class, 'thirdquarter']);
            Route::post('/setfourthquarter', [QuartersController::class, 'fourthquarter']);
        });

        // Routes for export
        Route::prefix('/export')->group(function () {
            Route::get('/generalfirstquarter', [ExportController::class, 'generalfirstquarter']);
            Route::get('/generalsecondquarter', [ExportController::class, 'generalsecondquarter']);
            Route::get('/generalthirdquarter', [ExportController::class, 'generalthirdquarter']);
            Route::get('/generalfourthquarter', [ExportController::class, 'generalfourthquarter']);
            Route::get('/generalfirstsemester', [ExportController::class, 'generalfirstsemester']);
            Route::get('/generalsecondsemester', [ExportController::class, 'generalsecondsemester']);

            Route::prefix('davaodeoro')->group(function () {
                Route::get('/firstquarter', [ExportController::class, 'davaodeorofirstquarter']);
                Route::get('/secondquarter', [ExportController::class, 'davaodeorosecondquarter']);
                Route::get('/thirdquarter', [ExportController::class, 'davaodeorothirdquarter']);
                Route::get('/fourthquarter', [ExportController::class, 'davaodeorofourthquarter']);
            });

            Route::prefix('davaooccidental')->group(function () {
                Route::get('/firstquarter', [ExportController::class, 'davaooccidentalfirstquarter']);
                Route::get('/secondquarter', [ExportController::class, 'davaooccidentalsecondquarter']);
                Route::get('/thirdquarter', [ExportController::class, 'davaooccidentalthirdquarter']);
                Route::get('/fourthquarter', [ExportController::class, 'davaooccidentalfourthquarter']);
            });

            Route::prefix('davaooriental')->group(function () {
                Route::get('/firstquarter', [ExportController::class, 'davaoorientalfirstquarter']);
                Route::get('/secondquarter', [ExportController::class, 'davaoorientalsecondquarter']);
                Route::get('/thirdquarter', [ExportController::class, 'davaoorientalthirdquarter']);
                Route::get('/fourthquarter', [ExportController::class, 'davaoorientalfourthquarter']);
            });

            Route::prefix('davaodelsur')->group(function () {
                Route::get('/firstquarter', [ExportController::class, 'davaodelsurfirstquarter']);
                Route::get('/secondquarter', [ExportController::class, 'davaodelsursecondquarter']);
                Route::get('/thirdquarter', [ExportController::class, 'davaodelsurthirdquarter']);
                Route::get('/fourthquarter', [ExportController::class, 'davaodelsurfourthquarter']);
            });

            Route::prefix('davaodelnorte')->group(function () {
                Route::get('/firstquarter', [ExportController::class, 'davaodelnortefirstquarter']);
                Route::get('/secondquarter', [ExportController::class, 'davaodelnortesecondquarter']);
                Route::get('/thirdquarter', [ExportController::class, 'davaodelnortethirdquarter']);
                Route::get('/fourthquarter', [ExportController::class, 'davaodelnortefourthquarter']);
            });

            Route::prefix('davaocity')->group(function () {
                Route::get('/firstquarter', [ExportController::class, 'davaocityfirstquarter']);
                Route::get('/secondquarter', [ExportController::class, 'davaocitysecondquarter']);
                Route::get('/thirdquarter', [ExportController::class, 'davaocitythirdquarter']);
                Route::get('/fourthquarter', [ExportController::class, 'davaocityfourthquarter']);
            });

        });


        // provinces for the admin
        Route::prefix('provinces')->group(function () {
            Route::prefix('/davaodeoro')->group(function () {
                Route::get('firstquarter', [DavaoDeOroController::class, 'davaodeorofirstquarter']);
                Route::get('secondquarter', [DavaoDeOroController::class, 'davaodeorosecondquarter']);
                Route::get('thirdquarter', [DavaoDeOroController::class, 'davaodeorothirdquarter']);
                Route::get('fourthquarter', [DavaoDeOroController::class, 'davaodeorofourthquarter']);
            });
            Route::prefix('/davaocity')->group(function () {
                Route::get('firstquarter', [DavaoCityController::class, 'davaocityfirstquarter']);
                Route::get('secondquarter', [DavaoCityController::class, 'davaocitysecondquarter']);
                Route::get('thirdquarter', [DavaoCityController::class, 'davaocitythirdquarter']);
                Route::get('fourthquarter', [DavaoCityController::class, 'davaocityfourthquarter']);
            });
            Route::prefix('/davaodelnorte')->group(function () {
                Route::get('firstquarter', [DavaoDelNorteController::class, 'davaodelnortefirstquarter']);
                Route::get('secondquarter', [DavaoDelNorteController::class, 'davaodelnortesecondquarter']);
                Route::get('thirdquarter', [DavaoDelNorteController::class, 'davaodelnortethirdquarter']);
                Route::get('fourthquarter', [DavaoDelNorteController::class, 'davaodelnortefourthquarter']);
            });
            Route::prefix('/davaodelsur')->group(function () {
                Route::get('firstquarter', [DavaoDelSurController::class, 'davaodelsurfirstquarter']);
                Route::get('secondquarter', [DavaoDelSurController::class, 'davaodelsursecondquarter']);
                Route::get('thirdquarter', [DavaoDelSurController::class, 'davaodelsurthirdquarter']);
                Route::get('fourthquarter', [DavaoDelSurController::class, 'davaodelsurfourthquarter']);
            });
            Route::prefix('/davaooccidental')->group(function () {
                Route::get('firstquarter', [DavaoOccidentalController::class, 'davaooccidentalfirstquarter']);
                Route::get('secondquarter', [DavaoOccidentalController::class, 'davaooccidentalsecondquarter']);
                Route::get('thirdquarter', [DavaoOccidentalController::class, 'davaooccidentalthirdquarter']);
                Route::get('fourthquarter', [DavaoOccidentalController::class, 'davaooccidentalfourthquarter']);
            });
            Route::prefix('/davaooriental')->group(function () {
                Route::get('firstquarter', [DavaoOrientalController::class, 'davaoorientalfirstquarter']);
                Route::get('secondquarter', [DavaoOrientalController::class, 'davaoorientalsecondquarter']);
                Route::get('thirdquarter', [DavaoOrientalController::class, 'davaoorientalthirdquarter']);
                Route::get('fourthquarter', [DavaoOrientalController::class, 'davaoorientalfourthquarter']);
            });
        });
    });

});




