<?php

use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\FormController;

Route::get('/receptionist/form', [FormController::class, 'create'])->name('form.create');
Route::post('/receptionist/store', [FormController::class, 'store'])->name('receptionist.store');
Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');

Route::get('secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');
Route::get('secretary/form/{id}', [SecretaryController::class, 'showForm'])->name('secretary.form');
Route::post('secretary/update/{id}', [SecretaryController::class, 'updateForm'])->name('secretary.update');

Route::get('/management/dashboard', [ManagementController::class, 'dashboard'])->name('management.dashboard');
Route::post('/management/approve/{form}', [ManagementController::class, 'approve'])->name('management.approve');
Route::post('/management/reject/{form}', [ManagementController::class, 'reject'])->name('management.reject');
