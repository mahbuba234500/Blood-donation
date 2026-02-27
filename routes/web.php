<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\BloodRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/locations/divisions/{division}/districts', [ProfileController::class, 'districtsByDivision']);
Route::get('/locations/districts/{district}/upazillas', [ProfileController::class, 'upazillasByDistrict']);
Route::get('/locations/dhaka/city-corporations', [ProfileController::class, 'dhakaCityCorporation']);
Route::get('/locations/dhaka/city-corporations/{cityCorporation}/areas', [ProfileController::class, 'areasByCityCorporation']);

Route::get('/blood-requests', [BloodRequestController::class, 'index'])
    ->name('blood-requests.index');

Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::get('/profile/complete', [ProfileController::class, 'completeForm'])->name('profile.complete');
    Route::post('/profile/complete', [ProfileController::class, 'completeStore'])->name('profile.complete.store');

    Route::get('/donor/dashboard', [DonorController::class, 'dashboard'])->name('donor.dashboard');
    Route::post('/donor/dashboard', [DonorController::class, 'update'])->name('donor.update');
});

Route::middleware('auth')->group(function () {



    Route::get('/blood-requests/create', [BloodRequestController::class, 'create'])->name('blood-requests.create');
    Route::post('/blood-requests', [BloodRequestController::class, 'store'])->name('blood-requests.store');

    Route::get('/my/blood-requests', [BloodRequestController::class, 'my'])->name('blood-requests.my');

    Route::patch('/blood-requests/{bloodRequest}/cancel', [BloodRequestController::class, 'cancel'])
        ->name('blood-requests.cancel');

    Route::patch('/blood-requests/{bloodRequest}/complete', [BloodRequestController::class, 'complete'])
        ->name('blood-requests.complete');
});

require __DIR__ . '/auth.php';
