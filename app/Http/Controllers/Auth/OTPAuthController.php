<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Vonage\Client as VonageClient;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
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

        try {
            $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
            $client = new VonageClient($basic);

            $from = env('VONAGE_BRAND_NAME') ?: 'YourApp';
            $messageText = "Your OTP is: $otp";

            Log::info("Sending SMS from $from to $to with message: $messageText");

            $response = $client->sms()->send(new SMS($to, $from, $messageText));
            $message = $response->current();

            Log::info("Vonage SMS status: " . $message->getStatus());

            if ($message->getStatus() != 0) {
                Log::error('SMS sending failed with status: ' . $message->getStatus());
                return redirect()->back()->withErrors([
                    'phone' => 'SMS sending failed. Status: ' . $message->getStatus()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            return redirect()->back()->withErrors([
                'phone' => 'Error sending SMS: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('auth.otp.verify.form')->with([
            'phone' => $to,
            'success' => 'OTP sent successfully. Please enter the code below.'
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

        $user = User::where('phone_number', $phone)
                    ->where('otp_code', $request->otp_code)
                    ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP']);
        }

        $user->otp_code = null;
        $user->save();

        Auth::login($user);

        return redirect('/home')->with('success', 'Logged in successfully.');
    }

    // Optional test method to test Vonage SMS manually
    public function testSendSMS()
    {
        try {
            $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
            $client = new VonageClient($basic);

            $to = '+855979480905'; // Replace with your test phone number
            $from = env('VONAGE_BRAND_NAME') ?: 'YourApp';
            $messageText = 'Test SMS from Laravel + Vonage.';

            $response = $client->sms()->send(new SMS($to, $from, $messageText));
            $message = $response->current();

            if ($message->getStatus() == 0) {
                return 'Test SMS sent successfully to ' . $to;
            } else {
                return 'Test SMS failed with status: ' . $message->getStatus();
            }
        } catch (\Exception $e) {
            return 'Error sending test SMS: ' . $e->getMessage();
        }
    }
}
