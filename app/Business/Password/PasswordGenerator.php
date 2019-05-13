<?php
declare(strict_types = 1);

namespace App\Business\Password;

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

class PasswordGenerator
{
    /**
     * @param $request
     *
     * @return string
     */
    public static function getPassword($request): string
    {
        $generator = new ComputerPasswordGenerator();

        $generator
            ->setUppercase(self::isChecked($request->uppercase))
            ->setLowercase(self::isChecked($request->lowercase))
            ->setNumbers(self::isChecked($request->numbers))
            ->setSymbols(self::isChecked($request->symbols))
            ->setLength((int)$request->password_length);

        $password = $generator->generatePassword();

        return $password;
    }

    /**
     * @param $data
     *
     * @return bool
     */
    private static function isChecked($data)
    {
        return $data ? true : false;
    }
}
