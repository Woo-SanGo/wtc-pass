<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if ($user) {
                // Update google_id if missing
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }

                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('default123'), // required, even if unused
                    'role' => 'user', // or 'shelter' or default
                ]);

                Auth::login($user);
            }

            return redirect('/home'); // or your landing page
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Google login failed.']);
        }
    }
}
