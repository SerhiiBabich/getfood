<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Auth;
use Exception;

class GoogleLoginController extends Controller
{
    /**
     * Create redirect to google api
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Return a callback from google api.
     * Create and login user.
     * @return collback URL from google
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $existUser = User::where('email', $googleUser->email)->first();

            if ($existUser) {
                Auth::login($existUser);
                return redirect()->route('home');
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id
                ]);
                Auth::login($user);
                return redirect()->route('home');
            }
        } catch (Exception $e) {
            return 'error';
        }
    }

}