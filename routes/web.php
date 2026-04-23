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

/* 🔥 ROOT → LANGSUNG KE LOGIN */
Route::get('/', function () {
    return redirect('/login');
});

/* 🔐 HARUS LOGIN */
Route::middleware(['auth'])->group(function () {

    /* 🔥 DASHBOARD (ROLE BASED) */
    Route::get('/dashboard', function () {

        if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin') {

            return view('admin.dashboard', [
                'totalServices' => Service::count(),
                'totalDonations' => Donation::sum('amount'),
            ]);

        } else {

            return view('user.home');
        }

    })->name('dashboard');

    /* 🔥 LOGOUT */
    Route::get('/auto-logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    });

    /* 🔥 RESOURCE */
    Route::resource('services', ServiceController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('counseling', CounselingController::class);
    Route::resource('service-registrations', ServiceRegistrationController::class);

});