<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\FormController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('login', [LoginController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware([RoleMiddleware::class . ':receptionist'])->group(function () {
    Route::get('/receptionist/form', [FormController::class, 'create'])->name('form.create');
    Route::post('/receptionist/store', [FormController::class, 'store'])->name('receptionist.store');
    Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');
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


// Receptionist routes

