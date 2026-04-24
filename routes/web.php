<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\ServiceRegistrationController;
use App\Models\Service;
use App\Models\Donation;

require __DIR__ . '/auth.php';

/*  ROOT → LOGIN */
Route::get('/', function () {
    return redirect('/login');
});


/*  DASHBOARD REDIRECT (PENTING) */
Route::get('/dashboard', function () {

    if (auth()->user()->role === 'user') {
        return redirect()->route('user.home');
    }

    return redirect()->route('admin.dashboard');
})->middleware('auth');


/*  LOGOUT */
Route::middleware('auth')->get('/auto-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});


/* 🔹 USER */
Route::middleware(['auth', 'role:user'])->get('/user/home', function () {
    return view('user.home');
})->name('user.home');


/* 🔹 ADMIN + SUPERADMIN DASHBOARD */
Route::middleware(['auth', 'role:admin,superadmin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'totalServices' => Service::count(),
        'totalDonations' => Donation::sum('amount'),
    ]);
})->name('admin.dashboard');


/*  ADMIN + SUPERADMIN */
Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::resource('services', ServiceController::class);
    Route::resource('counseling', CounselingController::class);
});


/*  SUPERADMIN ONLY */
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('donations', DonationController::class);
    Route::resource('service-registrations', ServiceRegistrationController::class);
});
