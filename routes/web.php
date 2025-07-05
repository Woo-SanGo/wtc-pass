<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ShelterController;
use App\Http\Controllers\Admin\AdoptionController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use App\Http\Controllers\Admin\ManagePetController;
use App\Http\Controllers\Auth\OtpLoginController;
use App\Exports\ShelterApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Auth\OTPAuthController;


// Public Pages (no auth needed)
Route::view('/', 'index')->name('home');
Route::view('/about', 'about');
Route::view('/blog', 'blog');
Route::view('/Adopt', 'Adopt');
Route::view('/blog-single', 'blog-single');
Route::view('/contact', 'contact');
Route::view('/gallery', 'gallery');
Route::view('/main', 'main');
Route::view('/pricing', 'pricing');
Route::view('/services', 'services');
Route::view('/vet', 'vet');

Route::get('/phone-login', [OTPAuthController::class, 'showPhoneForm'])->name('auth.phone.form');
Route::post('/phone-send', [OTPAuthController::class, 'requestOTP'])->name('auth.phone.send');
Route::get('/verify-otp', [OTPAuthController::class, 'showVerifyForm'])->name('auth.otp.verify.form');
Route::post('/verify-otp', [OTPAuthController::class, 'verifyOTP'])->name('auth.otp.verify');
Route::get('/test-send-sms', [OTPAuthController::class, 'testSendSMS']);

// Admin routes group
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::match(['post', 'put'], 'users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');

    Route::resource('adoptions', AdoptionController::class);
    Route::resource('shelters', ShelterController::class);
    Route::put('shelters/{id}', [ShelterController::class, 'update'])->name('shelters.update');

    Route::resource('managepet', ManagePetController::class);
    Route::resource('notifications', NotificationController::class);
    Route::get('/shelters/export', [ShelterController::class, 'export'])->name('shelters.export');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');

});



// Application forms
Route::get('/adoption', [ApplicationController::class, 'showAdoptionForm'])->name('applications.adoption-form');
Route::post('/adoption-submit', [ApplicationController::class, 'submitAdoption'])->name('applications.adoption-submit');
Route::resource('adoptions', AdoptionController::class)->middleware('auth');

Route::get('/shelter', [ApplicationController::class, 'showShelterForm'])->name('applications.shelter-form');
Route::post('/shelter-submit', [ApplicationController::class, 'submitShelter'])->name('applications.shelter-submit');

// Routes for blocked non-shelters to apply
Route::get('/apply-shelter', [ApplicationController::class, 'showShelterForm'])->name('applications.shelter-form');
Route::post('/apply-shelter', [ApplicationController::class, 'submitShelter'])->name('applications.shelter-submit');

// Shelter-specific pet management
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create')->middleware('auth');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store')->middleware('auth');

// Adopt page
Route::get('/adopt', [PetController::class, 'index'])->name('adopt.index');
Route::get('/adopt/{pet}', [PetController::class, 'show'])->name('adopt.show');

// Auth routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/test-send-sms', [OTPAuthController::class, 'testSendSMS']);


// Google Login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');