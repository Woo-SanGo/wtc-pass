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
use App\Http\Controllers\Auth\PhoneAuthController;


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

// Phone Authentication Routes
Route::get('/phone-register', [PhoneAuthController::class, 'showRegisterForm'])->name('auth.phone.register');
Route::post('/phone-register', [PhoneAuthController::class, 'register'])->name('auth.phone.register');
Route::get('/phone-login', [PhoneAuthController::class, 'showLoginForm'])->name('auth.phone.login');
Route::post('/phone-login', [PhoneAuthController::class, 'login'])->name('auth.phone.login');
Route::get('/phone-verify', [PhoneAuthController::class, 'showVerifyForm'])->name('auth.phone.verify');
Route::post('/phone-verify', [PhoneAuthController::class, 'verifyOTP'])->name('auth.phone.verify');

// Legacy OTP routes (keeping for compatibility)
Route::get('/phone-login-old', [OTPAuthController::class, 'showPhoneForm'])->name('auth.phone.form');
Route::post('/phone-send', [OTPAuthController::class, 'requestOTP'])->name('auth.phone.send');
Route::get('/verify-otp', [OTPAuthController::class, 'showVerifyForm'])->name('auth.otp.verify.form');
Route::post('/verify-otp', [OTPAuthController::class, 'verifyOTP'])->name('auth.otp.verify');
Route::get('/test-send-sms', [OTPAuthController::class, 'testSendSMS']);

// Admin routes group
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('shelters/export', [ShelterController::class, 'export'])->name('shelters.export');
    Route::get('test-export', function() {
        try {
            $export = new \App\Exports\ShelterApplicationsExport();
            $data = $export->collection();
            return response()->json(['success' => true, 'count' => $data->count()]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    })->name('test.export');
    
    Route::get('simple-export', function() {
        try {
            return Excel::download(new \App\Exports\SimpleExport, 'simple-test.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    })->name('simple.export');

    Route::resource('users', UserController::class);
    Route::match(['post', 'put'], 'users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');

    Route::resource('adoptions', AdoptionController::class);
    Route::resource('shelters', ShelterController::class);
    Route::put('shelters/{id}', [ShelterController::class, 'update'])->name('shelters.update');

    Route::resource('managepet', ManagePetController::class);
    Route::resource('notifications', NotificationController::class);

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

// Registration OTP verification routes
Route::get('/register-verify', [App\Http\Controllers\Auth\RegisterController::class, 'showVerifyForm'])->name('auth.register.verify');
Route::post('/register-verify', [App\Http\Controllers\Auth\RegisterController::class, 'verifyOTP'])->name('auth.register.verify');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/test-send-sms', [OTPAuthController::class, 'testSendSMS']);

Route::get('/debug-sms', function() {
    try {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $fromNumber = env('TWILIO_PHONE_NUMBER');

        if (!$accountSid || !$authToken || !$fromNumber) {
            return response()->json(['error' => 'Twilio credentials not configured'], 500);
        }

        $client = new \Twilio\Rest\Client($accountSid, $authToken);
        
        $message = $client->messages->create(
            '+855979480905',
            [
                'from' => $fromNumber,
                'body' => 'Debug SMS Test - ' . date('H:i:s')
            ]
        );
        
        return response()->json([
            'status' => $message->status,
            'message_id' => $message->sid,
            'success' => in_array($message->status, ['sent', 'delivered']),
            'account_sid' => $accountSid,
            'from_number' => $fromNumber
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/debug-otp', function() {
    // Get all users with phone numbers
    $users = \App\Models\User::whereNotNull('phone_number')->get();
    
    $phoneNumbers = $users->map(function($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone_number' => $user->phone_number,
            'otp_code' => $user->otp_code,
            'email' => $user->email
        ];
    });
    
    return response()->json([
        'total_users_with_phones' => $users->count(),
        'phone_numbers' => $phoneNumbers,
        'message' => 'All users with phone numbers'
    ]);
});

Route::get('/test-otp', function() {
    // Test OTP generation and storage
    $phone = '+855962689324';
    $otp = rand(100000, 999999);
    
    $user = \App\Models\User::updateOrCreate(
        ['phone_number' => $phone],
        [
            'otp_code' => $otp,
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]
    );
    
    $user->otp_code = $otp;
    $user->save();
    
    return response()->json([
        'message' => 'Test OTP created',
        'phone' => $phone,
        'otp' => $otp,
        'user_id' => $user->id,
        'saved_otp' => $user->otp_code
    ]);
});

// Google Login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');