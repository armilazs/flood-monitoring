<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/monitoring', function () {
    return view('pages.monitoring');
})->name('monitoring');

Route::get('/location/{slug}', function ($slug) {
    $locationName = ucwords(str_replace('-', ' ', $slug));
    return view('pages.location_detail', compact('locationName', 'slug'));
})->name('location.detail');

use App\Http\Controllers\MaintenanceController;

Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
Route::post('/maintenance/{id}', [MaintenanceController::class, 'update'])->name('maintenance.update');
Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy');

Route::get('/devices', function () {
    return view('pages.devices');
})->name('devices');

Route::get('/logs', function () {
    return view('pages.logs');
})->name('logs');

use App\Http\Controllers\SettingsController;

Route::get('/settings', function () {
    return view('pages.settings');
})->name('settings');

Route::post('/settings/add-admin', [SettingsController::class, 'addAdmin'])->name('settings.add_admin');
