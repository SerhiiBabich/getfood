<?php
declare(strict_types = 1);

namespace App\Bussiness\UserLogin;

use Laravel\Socialite\Two\User;
use Socialite;

class Social
{
    /**
     * @return User
     */
    public static function getGoogleUser(): User
    {
        return Socialite::driver('google')->stateless()->user();

    }
}
