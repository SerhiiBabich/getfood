<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get current auth user
     *
     * @return \App\Models\User
     */
    public static function currentUser(): User;

    /**
     * @param string
     *
     * @return bool
     */
    public static function checkPassword($password): bool;
}
