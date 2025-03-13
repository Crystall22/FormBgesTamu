<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\FormController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ParkingController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');
Route::get('login', [LoginController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');

Route::middleware([RoleMiddleware::class . ':receptionist'])->group(function () {
    Route::post('/receptionist/store', [FormController::class, 'store'])->name('receptionist.store');
    Route::get('/receptionist/form', [FormController::class, 'create'])->name('form.create');
    Route::get('/receptionist/deleteform', [FormController::class, 'deleteScreen'])->name('form.deleteScreen');
    Route::delete('/form/{id}', [FormController::class, 'destroy'])->name('form.destroy');
});

Route::middleware([RoleMiddleware::class . ':secretary'])->group(function () {
    Route::get('/secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');
    Route::get('/secretary/form/{id}', [SecretaryController::class, 'showForm'])->name('secretary.form');
    Route::post('/secretary/form/{id}', [SecretaryController::class, 'updateForm'])->name('secretary.update');
    Route::get('/secretary/download-pdf/{id}', [SecretaryController::class, 'downloadPdf'])->name('secretary.download.pdf');
});

Route::middleware([RoleMiddleware::class . ':management'])->group(function () {
    Route::get('/management/dashboard', [ManagementController::class, 'dashboard'])->name('management.dashboard');
    Route::put('/management/approve/{form}', [ManagementController::class, 'approve'])->name('management.approve');
    Route::put('/management/reject/{form}', [ManagementController::class, 'reject'])->name('management.reject');

});

Route::middleware([RoleMiddleware::class . ':security'])->group(function () {
    Route::get('/security/parkings', [ParkingController::class, 'index'])->name('parkings.index');
    Route::get('/security/parkings/create', [ParkingController::class, 'create'])->name('parkings.create');
    Route::post('/security/parkings', [ParkingController::class, 'store'])->name('parkings.store');
    Route::get('/security/parkings/{id}/edit', [ParkingController::class, 'edit'])->name('parkings.edit');
    Route::put('/security/parkings/{id}', [ParkingController::class, 'update'])->name('parkings.update');
    Route::get('/security/parkings/deletef', [ParkingController::class, 'deleteScreen'])->name('parkings.deleteScreen');
    Route::delete('/security/parkings/{id}', [ParkingController::class, 'destroy'])->name('parkings.destroy');
});
