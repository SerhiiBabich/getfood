<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
}
