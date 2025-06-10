<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkingController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
});
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::middleware('auth')->get('/profile', function () {
    return view('profile.profiles');
})->name('profile');

// Semua route di bawah ini hanya untuk user yang sudah login
Route::middleware('auth')->group(function () {

    // Dashboard umum
    Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/detail/{id}', [FormController::class, 'showDetail'])->name('dashboard.detail');
    // QR Detail (bisa di-scan siapa saja yang login)
    Route::get('/form/qr/{id}', [FormController::class, 'showQrDetail'])->name('form.qr');

    // Receptionist
    Route::middleware([RoleMiddleware::class . ':receptionist'])->group(function () {
        Route::get('/receptionist/form', [FormController::class, 'create'])->name('form.create');
        Route::post('/receptionist/store', [FormController::class, 'store'])->name('receptionist.store');
        Route::get('/receptionist/deleteform', [FormController::class, 'deleteScreen'])->name('form.deleteScreen');
        Route::delete('/form/{id}', [FormController::class, 'destroy'])->name('form.destroy');
        Route::get('/receptionist/form/{id}/qr', [FormController::class, 'showQrDetail'])->name('form.receptionist.qr'); // Menampilkan QR Code
    });

    // Secretary
    Route::middleware([RoleMiddleware::class . ':secretary'])->group(function () {
        Route::get('/secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');
        Route::get('/secretary/form/{id}', [SecretaryController::class, 'showForm'])->name('secretary.form');
        Route::post('/secretary/form/{id}', [SecretaryController::class, 'updateForm'])->name('secretary.update');
        Route::get('/secretary/download-pdf/{id}', [SecretaryController::class, 'downloadPdf'])->name('secretary.download.pdf');

        // User management (hanya secretary)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Management
    Route::middleware([RoleMiddleware::class . ':management'])->group(function () {
        Route::get('/management/dashboard/{type}', [ManagementController::class, 'dashboard'])
            ->name('management.dashboard')
            ->where('type', 'business|government|enterprise');
        Route::put('/management/approve/{form}', [ManagementController::class, 'approve'])
            ->name('management.approve');
        Route::put('/management/reject/{form}', [ManagementController::class, 'reject'])
            ->name('management.reject');
        Route::get('/management/form/{id}', [ManagementController::class, 'show'])
            ->name('management.show');
        Route::delete('/management/form/{id}', [ManagementController::class, 'destroy'])
            ->name('management.destroy');
    });

    // Security
    Route::middleware([RoleMiddleware::class . ':security'])->group(function () {
        Route::get('/security/parkings', [ParkingController::class, 'index'])->name('parkings.index');
        Route::get('/security/parkings/create', [ParkingController::class, 'create'])->name('parkings.create');
        Route::post('/security/parkings', [ParkingController::class, 'store'])->name('parkings.store');
        Route::get('/security/parkings/{id}/edit', [ParkingController::class, 'edit'])->name('parkings.edit');
        Route::put('/security/parkings/{id}', [ParkingController::class, 'update'])->name('parkings.update');
        Route::get('/security/parkings/deletef', [ParkingController::class, 'deleteScreen'])->name('parkings.deleteScreen');
        Route::delete('/security/parkings/{id}', [ParkingController::class, 'destroy'])->name('parkings.destroy');
        Route::get('/security/parkings/pinjam', [ParkingController::class, 'pinjamForm'])->name('parkings.pinjam');
        Route::post('/security/parkings/borrow', [ParkingController::class, 'borrow'])->name('parkings.borrow');
        Route::get('/security/parkings/return', [ParkingController::class, 'returnForm'])->name('parkings.returnForm');
        Route::post('/security/parkings/return', [ParkingController::class, 'return'])->name('parkings.return');
    });
});
