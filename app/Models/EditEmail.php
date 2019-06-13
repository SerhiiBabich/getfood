<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EditEmail extends Model
{
    const USED_TOKEN = 1;

    public $timestamps = false;
    
    protected $table = 'edit_email';

    protected $fillable =
        [
            'email',
            'token',
        ];


    public function saveEmailAndToken(string $email, string $token): bool
    {
        $this->email = $email;
        $this->token = $token;
        $this->token_created_at = Carbon::now();

        return $this->save();
    }

    public function usedToken(): bool
    {
        $this->used_token = self::USED_TOKEN;

        return $this->save();
    }
}
