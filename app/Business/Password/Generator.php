<?php
declare(strict_types = 1);

namespace App\Business\Password;

use Illuminate\Http\Request;

class Generator
{

    public static function getPassword($request): string
    {
        $passwordLenth = $request->password_lenth;
        $isLetters = $request->letters;
        $isCapitalLetters = $request->capital_letters;
        $isNumbers = $request->numbers;
        $isSpecial = $request->special;

        return self::createPassword($passwordLenth, $isLetters, $isCapitalLetters, $isNumbers, $isSpecial);
    }

    private static function createPassword($passwordLenth, $isLetters, $isCapitalLetters, $isNumbers, $isSpecial): string
    {
        $charactersArray = [];
        if($isLetters !== null) {
            $charactersArray[] = self::getCharsArray(97, 122);
        }

        if($isCapitalLetters !== null) {
            $charactersArray[] = self::getCharsArray(65, 90);
        }

        if($isNumbers !== null) {
            $charactersArray[] = range(0, 9);
        }

        if($isSpecial !== null) {
            $charactersArray[] = self::getCharsArray(33, 43);
        }

        $password = self::getReqiredSymbols($charactersArray);
        $password .= self::getRemainingSymbols($charactersArray, $passwordLenth);

        return str_shuffle($password);
    }

    private static function getCharsArray($x, $y): array
    {
        $numbers = range($x, $y);
        return array_map('chr', $numbers);
    }

    private static function getReqiredSymbols($charactersArray): string
    {
        $string = '';
        foreach ($charactersArray as $characters) {
            shuffle($characters);
            $string .= $characters[0];
        }

        return $string;
    }

    private static function getRemainingSymbols($charactersArray, $passwordLenth): string
    {
        $quantity = $passwordLenth - count($charactersArray);
        $unifiedArray = call_user_func_array('array_merge', $charactersArray);

        $string = '';
        for($i=0; $i<$quantity; $i++) {
            shuffle($unifiedArray);
            $string .=$unifiedArray[0];
        }

        return $string;
    }
}
