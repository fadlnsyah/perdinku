<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\Employee\EmployeeBusinessTripController;
use App\Http\Controllers\Employee\TripEstimationController;
use App\Http\Controllers\Sdm\SdmBusinessTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::middleware('role:PEGAWAI')->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::post('/perdin/estimate', [TripEstimationController::class, 'estimate'])->name('perdin.estimate');
        Route::resource('perdin', EmployeeBusinessTripController::class)
            ->only(['index', 'create', 'store', 'show'])
            ->parameters(['perdin' => 'businessTrip']);
    });

    Route::middleware('role:SDM')->prefix('sdm')->name('sdm.')->group(function () {
        Route::get('/pengajuan', [SdmBusinessTripController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{businessTrip}', [SdmBusinessTripController::class, 'show'])->name('pengajuan.show');
        Route::post('/pengajuan/{businessTrip}/approve', [SdmBusinessTripController::class, 'approve'])->name('pengajuan.approve');
        Route::post('/pengajuan/{businessTrip}/reject', [SdmBusinessTripController::class, 'reject'])->name('pengajuan.reject');
    });

    Route::middleware('role:ADMIN')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('cities', CityController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';
