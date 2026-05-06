<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\ServiceRegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PastorController;

use App\Models\Service;
use App\Models\Donation;

require __DIR__ . '/auth.php';


/* ROOT */
Route::get('/', fn() => redirect('/login'));


/* LOGOUT */
Route::middleware('auth')->get('/auto-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});


/* DASHBOARD REDIRECT */
Route::middleware('auth')->get('/dashboard', function () {

    return match (auth()->user()->role) {
        'user' => redirect()->route('user.home'),
        'admin' => redirect()->route('admin.dashboard'),
        default => redirect()->route('superadmin.dashboard'),
    };
});


/* ===================================
   USER
=================================== */

Route::middleware(['auth', 'session.timeout', 'role:user,admin,superadmin'])->group(function () {

    Route::get('/user/home', function () {
        return view('user.home', [
            'totalServices' => Service::count(),
            'services' => Service::latest()->take(3)->get()
        ]);
    })->name('user.home');

    Route::get('/user/services', [ServiceController::class, 'userIndex'])
        ->name('user.services');

    Route::get('/user/donation', [DonationController::class, 'userForm'])
        ->name('user.donation');

    Route::post('/user/donation', [DonationController::class, 'userStore'])
        ->name('user.donation.store');

    Route::get('/user/pelayanan', [ServiceRegistrationController::class, 'myService'])
        ->name('user.pelayanan');

    Route::post('/user/pelayanan', [ServiceRegistrationController::class, 'store'])
        ->name('user.pelayanan.store');

    Route::get('/user/counseling', [CounselingController::class, 'userView'])
        ->name('user.counseling');

    Route::post('/user/counseling', [CounselingController::class, 'userStore'])
        ->name('user.counseling.store');

    Route::delete('/user/counseling/{id}/cancel', [CounselingController::class, 'userCancel'])
        ->name('user.counseling.cancel');
});


/* ===================================
   ADMIN
=================================== */

Route::middleware(['auth', 'session.timeout', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard', [
            'totalServices' => Service::count(),
            'totalDonations' => Donation::sum('amount'),
        ]);
    })->name('admin.dashboard');

    Route::get('/admin/pelayanan', [ServiceRegistrationController::class, 'index'])
        ->name('admin.pelayanan');
});


/* ===================================
   SUPERADMIN
=================================== */

Route::middleware(['auth', 'session.timeout', 'role:superadmin'])->group(function () {

    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.users.dashboard', [
            'totalServices' => Service::count(),
            'totalDonations' => Donation::sum('amount'),
        ]);
    })->name('superadmin.dashboard');
});


/* ===================================
   ADMIN + SUPERADMIN
=================================== */

Route::middleware(['auth', 'session.timeout', 'role:admin,superadmin'])->group(function () {

    Route::resource('services', ServiceController::class);

    Route::resource('counseling', CounselingController::class);

    /* Route export harus sebelum resource agar tidak tertangkap sebagai {donation} */
    Route::get('/donations/export', [DonationController::class, 'export'])
        ->name('donations.export')
        ->middleware('role:superadmin');

    Route::resource('donations', DonationController::class);

    Route::resource('service-registrations', ServiceRegistrationController::class);

    Route::resource('pastors', PastorController::class)->except(['show', 'create']);
});


/* ===================================
   USER MANAGEMENT
=================================== */

/* Admin */
Route::middleware(['auth', 'session.timeout', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('users', UserController::class);
    });

/* Superadmin */
Route::middleware(['auth', 'session.timeout', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::resource('users', UserController::class);
    });
