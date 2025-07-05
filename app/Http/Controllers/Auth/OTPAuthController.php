<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Support\Facades\Log;

class OTPAuthController extends Controller
{
    // Show phone number input form
    public function showPhoneForm()
    {
        return view('auth.phone-login');
    }

    // Handle OTP request and send SMS
    public function requestOTP(Request $request)
    {
        Log::info('OTP request received'); // ✅ Step tracking

        $request->validate([
            'phone' => ['required', 'regex:/^(855|\+855|0)[0-9]{8,}$/'],
        ]);

        $otp = rand(100000, 999999);

        // Format phone number
        $to = $request->phone;
        if (strpos($to, '0') === 0) {
            $to = '+855' . substr($to, 1);
        } elseif (strpos($to, '855') === 0) {
            $to = '+' . $to;
        }

        Log::info("Final phone number: $to");
        Log::info("Generated OTP: $otp");

        // Create or update user
        $user = User::updateOrCreate(
            ['phone_number' => $to],
            [
                'otp_code' => $otp,
                'name' => 'PhoneUser' . rand(1000, 9999),
                'email' => 'user' . rand(1000, 9999) . '@phone-login.fake',
                'password' => bcrypt('otp_password'),
            ]
        );

        // Force save the OTP to ensure it's stored
        $user->otp_code = $otp;
        $user->save();

        Log::info("User created/updated: " . $user->id);
        Log::info("OTP saved: " . $user->otp_code);

        try {
            // Check if we're in test mode
            if (env('SMS_TEST_MODE', false)) {
                Log::info("TEST MODE: OTP $otp would be sent to $to");
                Log::info("TEST MODE: In production, this would send SMS via Twilio");
                
                return redirect()->route('auth.otp.verify.form')->with([
                    'phone' => $to,
                    'success' => "TEST MODE: Your OTP is: $otp (SMS would be sent in production)",
                    'test_otp' => $otp
                ]);
            }

            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $fromNumber = env('TWILIO_PHONE_NUMBER');

            if (!$accountSid || !$authToken || !$fromNumber) {
                throw new \Exception('Twilio credentials not configured');
            }

            $client = new TwilioClient($accountSid, $authToken);
            $messageText = "Your HomePet OTP is: $otp";

            Log::info("Sending SMS from $fromNumber to $to with message: $messageText");
            Log::info("Twilio Account SID: " . $accountSid);

            $message = $client->messages->create(
                $to, // To
                [
                    'from' => $fromNumber,
                    'body' => $messageText
                ]
            );

            Log::info("Twilio SMS SID: " . $message->sid);
            Log::info("Twilio SMS Status: " . $message->status);

            if ($message->status === 'failed' || $message->status === 'undelivered') {
                Log::error('SMS sending failed with status: ' . $message->status);
                return redirect()->back()->withErrors([
                    'phone' => 'SMS sending failed. Status: ' . $message->status
                ]);
            }

            Log::info('SMS sent successfully via Twilio');

        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            
            // If Twilio fails, fall back to test mode
            Log::info("Falling back to test mode due to Twilio error");
            return redirect()->route('auth.otp.verify.form')->with([
                'phone' => $to,
                'success' => "SMS failed, but here's your OTP: $otp (Please verify your phone in Twilio)",
                'test_otp' => $otp
            ]);
        }

        return redirect()->route('auth.otp.verify.form')->with([
            'phone' => $to,
            'success' => 'OTP sent successfully. Please enter the code below. If you don\'t receive it, check your spam folder or try again.'
        ]);
    }

    // Show OTP verification form
    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }

    // Verify the OTP code and log user in
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp_code' => 'required|numeric'
        ]);

        $phone = $request->phone;

        // Normalize the phone
        if (strpos($phone, '0') === 0) {
            $phone = '+855' . substr($phone, 1);
        } elseif (strpos($phone, '855') === 0) {
            $phone = '+' . $phone;
        }

        Log::info("Verifying OTP for phone: $phone");
        Log::info("Entered OTP: " . $request->otp_code);

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

        $user->otp_code = null;
        $user->save();

        Auth::login($user);

        Log::info("User logged in successfully: " . $user->name);

        return redirect('/home')->with('success', 'Logged in successfully.');
    }

    // Optional test method to test Twilio SMS manually
    public function testSendSMS()
    {
        try {
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $fromNumber = env('TWILIO_PHONE_NUMBER');

            if (!$accountSid || !$authToken || !$fromNumber) {
                return 'Twilio credentials not configured';
            }

            $client = new TwilioClient($accountSid, $authToken);
            $to = '+855979480905'; // Replace with your test phone number
            $messageText = 'Test SMS from Laravel + Twilio.';

            $message = $client->messages->create(
                $to,
                [
                    'from' => $fromNumber,
                    'body' => $messageText
                ]
            );

            if ($message->status === 'sent' || $message->status === 'delivered') {
                return 'Test SMS sent successfully to ' . $to . ' (SID: ' . $message->sid . ')';
            } else {
                return 'Test SMS failed with status: ' . $message->status;
            }
        } catch (\Exception $e) {
            return 'Error sending test SMS: ' . $e->getMessage();
        }
    }
}
