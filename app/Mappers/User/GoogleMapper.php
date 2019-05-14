<?php
declare(strict_types = 1);

namespace App\Mappers\User;

use App\Models\User;

class GoogleMapper
{
    /**
     * @param $googleData
     *
     * @return User
     */
    public static function mapGoogleUserDataToUserEntity($googleData): User
    {
        $user = User::create([
            'name' => $googleData->name,
            'email' => $googleData->email,
            'google_id' => $googleData->id
        ]);

        return $user;
    }
}
