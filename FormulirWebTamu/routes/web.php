<?php

use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ManagementController;


Route::get('/receptionist/form', [ReceptionistController::class, 'showForm'])->name('receptionist.form'); // Display form
Route::post('/receptionist/form', [ReceptionistController::class, 'createForm'])->name('receptionist.store'); // Handle form submission


Route::get('/secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');
Route::post('/secretary/forward/{form}', [SecretaryController::class, 'addNoteAndForward'])->name('secretary.forward');

Route::get('/management/dashboard', [ManagementController::class, 'dashboard'])->name('management.dashboard');
Route::post('/management/approve/{form}', [ManagementController::class, 'approve'])->name('management.approve');
Route::post('/management/reject/{form}', [ManagementController::class, 'reject'])->name('management.reject');
