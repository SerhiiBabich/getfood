<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Mappers\User\GoogleMapper;
use App\Models\User;

class UserRepository
{
    /**
     * @param $email
     *
     * @return User
     */
    public static function findOneUserByEmail(string $email): User
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    /**
     * @param $googleData
     *
     * @return User
     */
    public static function createUserWithGoogleData($googleData): User
    {
        $user = GoogleMapper::mapGoogleUserDataToUserEntity($googleData);

        return $user;
    }
}
