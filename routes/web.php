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

Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::get('/profile/complete', [ProfileController::class, 'completeForm'])->name('profile.complete');
    Route::post('/profile/complete',[ProfileController::class, 'completeStore'])->name('profile.complete.store');

    Route::get('/locations/divisions/{division}/districts',[ProfileController::class,'districtByDivision'])->name('locations.districts');
    Route::get('locations/districts/{district}/areas', [ProfileController::class, 'areasByDistrict'])->name('locations.areas');

    Route::get('/donor/dashboard', [DonorController::class, 'dashboard'])->name('donor.dashboard');
    Route::post('/donor/dashboard', [DonorController::class, 'update'])->name('donor.update');
});

require __DIR__.'/auth.php';
