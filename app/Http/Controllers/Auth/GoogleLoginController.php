<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Bussiness\UserLogin\Social;
use Socialite;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\RedirectResponse;

class GoogleLoginController extends Controller
{
    /**
     * Create redirect to google api from auth form
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create redirect to google api from registration form
     *
     * @return RedirectResponse
     */
    public function registration(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Return a callback from google api.
     * Create and login user.
     *
     * @return RedirectResponse
     */
    public function callback(): RedirectResponse
    {
        $googleUser = Social::getGoogleUser();
        $existUser = UserRepository::findOneUserByEmail(
            $googleUser->email
        );

        if ($existUser !== null) {
            Auth::login($existUser);
            return redirect()->route('home');
        } else {
            $userEntity = UserRepository::createUserWithGoogleData($googleUser);
            Auth::login($userEntity);
            return redirect()->route('home');
        }
    }

}
