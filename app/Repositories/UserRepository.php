<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get current auth user
     *
     * @return \App\Models\User
     */
    public static function currentUser(): User
    {
        return Auth::user();
    }

    /**
     * Check is the input password matches the current one
     *
     * @param string
     *
     * @return bool
     */
    public static function checkPassword($password): bool
    {
        return Hash::check($password, self::currentUser()->password);
    }
}
