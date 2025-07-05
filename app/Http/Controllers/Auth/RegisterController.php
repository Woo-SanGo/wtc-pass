<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client as TwilioClient;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/^(855|\+855|0)[0-9]{8,}$/', 'unique:users,phone_number'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:user,shelter,admin'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Format phone number
        $phone = $data['phone'];
        if (strpos($phone, '0') === 0) {
            $phone = '+855' . substr($phone, 1);
        } elseif (strpos($phone, '855') === 0) {
            $phone = '+' . $phone;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $phone,
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'user',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Create user with pending status
        $user = $this->create($request->all());
        
        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->save();

        Log::info("Registration OTP generated for user: " . $user->id);
        Log::info("Phone: " . $user->phone_number . ", OTP: " . $otp);

        // Send OTP via SMS
        try {
            if (env('SMS_TEST_MODE', false)) {
                Log::info("TEST MODE: Registration OTP $otp would be sent to " . $user->phone_number);
                
                return redirect()->route('auth.register.verify')->with([
                    'user_id' => $user->id,
                    'phone' => $user->phone_number,
                    'name' => $user->name,
                    'success' => "TEST MODE: Your registration OTP is: $otp",
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
            $messageText = "Your HomePet registration OTP is: $otp";

            Log::info("Sending registration SMS from $fromNumber to " . $user->phone_number);

            $message = $client->messages->create(
                $user->phone_number,
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
            return redirect()->route('auth.register.verify')->with([
                'user_id' => $user->id,
                'phone' => $user->phone_number,
                'name' => $user->name,
                'success' => "SMS failed, but here's your registration OTP: $otp",
                'test_otp' => $otp
            ]);
        }

        return redirect()->route('auth.register.verify')->with([
            'user_id' => $user->id,
            'phone' => $user->phone_number,
            'name' => $user->name,
            'success' => 'Registration OTP sent successfully. Please verify your phone number.'
        ]);
    }

    /**
     * Show OTP verification form for registration
     */
    public function showVerifyForm()
    {
        if (!session('user_id')) {
            return redirect()->route('register');
        }
        
        return view('auth.register-verify');
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp_code' => 'required|numeric'
        ]);

        $user = User::find($request->user_id);
        
        if (!$user) {
            return redirect()->route('register')->withErrors(['otp_code' => 'User not found']);
        }

        Log::info("Verifying OTP for user: " . $user->id);
        Log::info("Entered OTP: " . $request->otp_code . ", Stored OTP: " . ($user->otp_code ?? 'NULL'));

        if ($user->otp_code != $request->otp_code) {
            return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP. Please check and try again.']);
        }

        // Clear OTP and mark user as verified
        $user->otp_code = null;
        $user->email_verified_at = now();
        $user->save();

        // Log in user
        auth()->login($user);

        Log::info("User registration completed successfully: " . $user->name);

        return redirect($this->redirectTo)->with('success', 'Registration successful! Welcome to HomePet.');
    }
}
