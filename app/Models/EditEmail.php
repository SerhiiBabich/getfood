<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EditEmail extends Model
{
    const USED_TOKEN = 1;

    public $timestamps = false;

    protected $dates = ['token_created_at'];

    protected $table = 'edit_email';
    
    public static function whereToken(string $token): EditEmail
    {
        return EditEmail::where('token', '=', $token)->firstOrFail();
    }

    public function saveEmailAndToken(string $email, string $token): bool
    {
        $this->email            = $email;
        $this->token            = $token;
        $this->token_created_at = Carbon::now();

        return $this->save();
    }

    public function usedToken(int $USED_TOKEN = self::USED_TOKEN): bool
    {
        $this->used_token = $USED_TOKEN;

        return $this->save();
    }
}
