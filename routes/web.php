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

/* HOME */
Route::get('/', function () {
    $services = Service::latest()->get();
    return view('home', compact('services'));
});

Route::get('/auto-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
});

/* 🔐 HARUS LOGINn */
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalServices' => Service::count(),
            'totalDonations' => Donation::sum('amount'),
        ]);
    })->name('dashboard');

    Route::resource('services', ServiceController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('counseling', CounselingController::class);
    Route::resource('service-registrations', ServiceRegistrationController::class);

});