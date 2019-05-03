<?php

namespace App\Business;

use Illuminate\Http\Request;

class Generator
{
    public function getPass(Request $request)
    {
        $passwordType = $request->password_type;
        $passwordLenth = $request->password_lenth;

        switch ($passwordType) {
            case 'null':
                $password = self::generateSimplePass($passwordLenth);
                break;
            case 'add_numbers':
                $password = self::generatePassWithNumbers($passwordLenth);
                break;
            case 'add_special_chars':
                $password = self::generatePassWithChars($passwordLenth);
                break;
        }
    }
}
