<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client as TwilioClient;

class PhoneAuthController extends Controller
{
    // Show phone registration form
    public function showRegisterForm()
    {
        return view('auth.phone-register');
    }

    // Show phone login form
    public function showLoginForm()
    {
        return view('auth.phone-login');
    }

    // Handle phone registration with OTP
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(855|\+855|0)[0-9]{8,}$/', 'unique:users,phone_number'],
        ]);

        $otp = rand(100000, 999999);

        // Format phone number
        $phone = $request->phone;
        if (strpos($phone, '0') === 0) {
            $phone = '+855' . substr($phone, 1);
        } elseif (strpos($phone, '855') === 0) {
            $phone = '+' . $phone;
        }

        Log::info("Registration OTP request for phone: $phone");
        Log::info("Generated OTP: $otp");

        // Create user with pending status
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $phone,
            'otp_code' => $otp,
            'email' => 'user' . rand(1000, 9999) . '@phone-register.fake',
            'password' => bcrypt('phone_password_' . rand(1000, 9999)),
            'role' => 'user',
        ]);

        // Force save the OTP
        $user->otp_code = $otp;
        $user->save();

        Log::info("User created for registration: " . $user->id);
        Log::info("OTP saved: " . $user->otp_code);

        try {
            // Check if we're in test mode
            if (env('SMS_TEST_MODE', false)) {
                Log::info("TEST MODE: Registration OTP $otp would be sent to $phone");
                
                return redirect()->route('auth.phone.verify')->with([
                    'phone' => $phone,
                    'name' => $request->name,
                    'success' => "TEST MODE: Your registration OTP is: $otp",
                    'test_otp' => $otp,
                    'is_registration' => true
                ]);
            }

            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $fromNumber = env('TWILIO_PHONE_NUMBER');

            if (!$accountSid || !$authToken || !$fromNumber) {
                throw new \Exception('Twilio credentials not configured');
            }

            $client = new TwilioClient($accountSid, $authToken);
            $messageText = "Your HomePet registration OTP is: $otp";

            Log::info("Sending registration SMS from $fromNumber to $phone");

            $message = $client->messages->create(
                $phone,
                [
                    'from' => $fromNumber,
                    'body' => $messageText
                ]
            );

            Log::info("Registration SMS SID: " . $message->sid);
            Log::info("Registration SMS Status: " . $message->status);

            if ($message->status === 'failed' || $message->status === 'undelivered') {
                throw new \Exception('SMS sending failed with status: ' . $message->status);
            }

        } catch (\Exception $e) {
            Log::error('Error sending registration SMS: ' . $e->getMessage());
            
            // Fall back to test mode
            return redirect()->route('auth.phone.verify')->with([
                'phone' => $phone,
                'name' => $request->name,
                'success' => "SMS failed, but here's your registration OTP: $otp",
                'test_otp' => $otp,
                'is_registration' => true
            ]);
        }

        return redirect()->route('auth.phone.verify')->with([
            'phone' => $phone,
            'name' => $request->name,
            'success' => 'Registration OTP sent successfully. Please verify your phone number.',
            'is_registration' => true
        ]);
    }

    // Handle phone login with OTP
    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^(855|\+855|0)[0-9]{8,}$/'],
        ]);

        $otp = rand(100000, 999999);

        // Format phone number
        $phone = $request->phone;
        if (strpos($phone, '0') === 0) {
            $phone = '+855' . substr($phone, 1);
        } elseif (strpos($phone, '855') === 0) {
            $phone = '+' . $phone;
        }

        Log::info("Login OTP request for phone: $phone");
        Log::info("Generated OTP: $otp");

        // Find existing user or create new one
        $user = User::where('phone_number', $phone)->first();
        
        if (!$user) {
            return redirect()->back()->withErrors([
                'phone' => 'No account found with this phone number. Please register first.'
            ]);
        }

        // Update OTP
        $user->otp_code = $otp;
        $user->save();

        Log::info("User found for login: " . $user->id);
        Log::info("OTP saved: " . $user->otp_code);

        try {
            // Check if we're in test mode
            if (env('SMS_TEST_MODE', false)) {
                Log::info("TEST MODE: Login OTP $otp would be sent to $phone");
                
                return redirect()->route('auth.phone.verify')->with([
                    'phone' => $phone,
                    'name' => $user->name,
                    'success' => "TEST MODE: Your login OTP is: $otp",
                    'test_otp' => $otp,
                    'is_registration' => false
                ]);
            }

            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $fromNumber = env('TWILIO_PHONE_NUMBER');

            if (!$accountSid || !$authToken || !$fromNumber) {
                throw new \Exception('Twilio credentials not configured');
            }

            $client = new TwilioClient($accountSid, $authToken);
            $messageText = "Your HomePet login OTP is: $otp";

            Log::info("Sending login SMS from $fromNumber to $phone");

            $message = $client->messages->create(
                $phone,
                [
                    'from' => $fromNumber,
                    'body' => $messageText
                ]
            );

            Log::info("Login SMS SID: " . $message->sid);
            Log::info("Login SMS Status: " . $message->status);

            if ($message->status === 'failed' || $message->status === 'undelivered') {
                throw new \Exception('SMS sending failed with status: ' . $message->status);
            }

        } catch (\Exception $e) {
            Log::error('Error sending login SMS: ' . $e->getMessage());
            
            // Fall back to test mode
            return redirect()->route('auth.phone.verify')->with([
                'phone' => $phone,
                'name' => $user->name,
                'success' => "SMS failed, but here's your login OTP: $otp",
                'test_otp' => $otp,
                'is_registration' => false
            ]);
        }

        return redirect()->route('auth.phone.verify')->with([
            'phone' => $phone,
            'name' => $user->name,
            'success' => 'Login OTP sent successfully. Please verify your phone number.',
            'is_registration' => false
        ]);
    }

    // Show OTP verification form
    public function showVerifyForm()
    {
        return view('auth.phone-verify');
    }

    // Verify OTP and complete registration/login
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp_code' => 'required|numeric',
            'is_registration' => 'required|boolean'
        ]);

        $phone = $request->phone;
        $isRegistration = $request->is_registration;

        // Normalize the phone
        if (strpos($phone, '0') === 0) {
            $phone = '+855' . substr($phone, 1);
        } elseif (strpos($phone, '855') === 0) {
            $phone = '+' . $phone;
        }

        Log::info("Verifying OTP for phone: $phone");
        Log::info("Entered OTP: " . $request->otp_code);
        Log::info("Is registration: " . ($isRegistration ? 'Yes' : 'No'));

        $user = User::where('phone_number', $phone)->first();

        if (!$user) {
            Log::error("No user found for phone: $phone");
            return redirect()->back()->withErrors(['otp_code' => 'No user found with this phone number']);
        }

        Log::info("User found: " . $user->name);
        Log::info("Stored OTP: " . ($user->otp_code ?? 'NULL'));

        if ($user->otp_code != $request->otp_code) {
            Log::error("OTP mismatch - Entered: " . $request->otp_code . ", Stored: " . ($user->otp_code ?? 'NULL'));
            return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP. Please check and try again.']);
        }

        // Clear OTP
        $user->otp_code = null;
        $user->save();

        // Log in user
        Auth::login($user);

        Log::info("User logged in successfully: " . $user->name);

        if ($isRegistration) {
            return redirect('/home')->with('success', 'Registration successful! Welcome to HomePet.');
        } else {
            return redirect('/home')->with('success', 'Login successful! Welcome back.');
        }
    }
} 