<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkingController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CustomerServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CallCenterController;

// Redirect root ke landing
Route::get('/', fn() => redirect()->route('landing'))->name('landing');

// Route untuk halaman landing
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
});
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routing untuk profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // Menampilkan halaman profil
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Memperbarui profil

    // Routing untuk ubah password
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password'); // Menampilkan form ubah password
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.update'); // Memproses ubah password
});

Route::middleware('auth')->group(function () {

    // Dashboard umum
    Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');


    // Receptionist
    Route::middleware([RoleMiddleware::class . ':receptionist'])->group(function () {
        Route::get('/receptionist/form', [FormController::class, 'create'])->name('form.create');
        Route::post('/receptionist/store', [FormController::class, 'store'])->name('receptionist.store');
        Route::get('/receptionist/deleteform', [FormController::class, 'deleteScreen'])->name('form.deleteScreen');
        Route::delete('/form/{id}', [FormController::class, 'destroy'])->name('form.destroy');
        Route::post('/receptionist/delete-period', [FormController::class, 'bulkDelete'])->name('form.bulkDelete');
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
        Route::get('/security/parkings/{id}/details', [ParkingController::class, 'showDetails'])->name('parkings.details');
        Route::put('/security/parkings/{id}/update-details', [ParkingController::class, 'updateDetails'])->name('parkings.updateDetails');
        Route::delete('/security/parkings/{id}', [ParkingController::class, 'destroy'])->name('parkings.destroy');
        Route::get('/security/parkings/pinjam', [ParkingController::class, 'pinjamForm'])->name('parkings.pinjam');
        Route::post('/security/parkings/borrow', [ParkingController::class, 'borrow'])->name('parkings.borrow');
        Route::get('/security/parkings/return', [ParkingController::class, 'returnForm'])->name('parkings.returnForm');
        Route::post('/security/parkings/return', [ParkingController::class, 'return'])->name('parkings.return');
    });


    Route::middleware([RoleMiddleware::class . ':customer_service'])->prefix('customerservice')->group(function () {
        Route::get('/modem', [CustomerServiceController::class, 'index'])->name('customerservice.modem.index');
        Route::get('/modem/create', [CustomerServiceController::class, 'create'])->name('customerservice.modem.create');
        Route::post('/modem', [CustomerServiceController::class, 'store'])->name('customerservice.modem.store');
        Route::get('/modem/{id}/edit', [CustomerServiceController::class, 'edit'])->name('customerservice.modem.edit');
        Route::put('/modem/{id}', [CustomerServiceController::class, 'update'])->name('customerservice.modem.update');
        Route::delete('/modem/{id}', [CustomerServiceController::class, 'destroy'])->name('customerservice.modem.destroy');
        Route::get('/modem/export', [CustomerServiceController::class, 'export'])->name('customerservice.modem.export');
        Route::get('/queue/list', [QueueController::class, 'index'])->name('customerservice.queue-list');
        Route::delete('/queue/delete/{id}', [QueueController::class, 'destroy'])->name('queue.destroy');

        // Routing untuk pendataan call center
        Route::get('/call-center', [CallCenterController::class, 'index'])->name('customerservice.call-center.index'); // Menampilkan halaman rekap data
        Route::get('/call-center/create', [CallCenterController::class, 'create'])->name('customerservice.call-center.create'); // Menampilkan halaman tambah data
        Route::post('/call-center', [CallCenterController::class, 'store'])->name('customerservice.call-center.store'); // Menyimpan data panggilan
        Route::delete('/call-center/{id}', [CallCenterController::class, 'destroy'])->name('customerservice.call-center.destroy'); // Menghapus data panggilan
        Route::get('/call-center/export', [CallCenterController::class, 'export'])->name('customerservice.call-center.export'); // Export data ke Excel


    });
    // Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/user/{id}', [ChatController::class, 'chatWithUser'])->name('chat.user');
    Route::post('/chat/send/{id}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread/count', [ChatController::class, 'unreadCount'])->name('chat.unread.count');
    Route::get('/chat/unread/list', [ChatController::class, 'unreadList'])->name('chat.unread.list');

});


// Route publik untuk detail form (tanpa auth)
Route::get('/form/{id}/detail', [FormController::class, 'showDetail'])->name('form.detail');
Route::get('/form/{id}/download-qr', [FormController::class, 'downloadQr'])->name('form.downloadQr');

// Tambahkan route publik untuk QR detail dan dashboard detail
Route::get('/receptionist/form/{id}/qr', [FormController::class, 'showQrDetail'])->name('receptionist.qr-detail');
Route::get('/dashboard/detail/{id}', [FormController::class, 'showDetail'])->name('dashboard.detail');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Routing untuk guest
Route::get('/queue', [QueueController::class, 'create'])->name('queue.create');
Route::post('/queue', [QueueController::class, 'store'])->name('queue.store');
Route::get('/queue/number/{queue}', [QueueController::class, 'show'])->name('queue.show');


Route::get('/chat/user/{id}/fetch', [ChatController::class, 'fetchMessages'])->name('chat.fetch')->middleware('auth');// Semua route di bawah ini hanya untuk user yang sudah login

