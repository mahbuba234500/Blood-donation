<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/locations/divisions/{division}/districts', [ProfileController::class,'districtsByDivision']);
Route::get('/locations/districts/{district}/upazillas', [ProfileController::class,'upazillasByDistrict']);
Route::get('/locations/dhaka/city-corporations', [ProfileController::class, 'dhakaCityCorporation']);
Route::get('/locations/dhaka/city-corporations/{cityCorporation}/areas', [ProfileController::class,'areasByCityCorporation']);


Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::get('/profile/complete', [ProfileController::class, 'completeForm'])->name('profile.complete');
    Route::post('/profile/complete',[ProfileController::class, 'completeStore'])->name('profile.complete.store');

    Route::get('/donor/dashboard', [DonorController::class, 'dashboard'])->name('donor.dashboard');
    Route::post('/donor/dashboard', [DonorController::class, 'update'])->name('donor.update');
});

require __DIR__.'/auth.php';
