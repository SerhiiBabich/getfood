<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditEmail extends Model
{
    protected $table = 'edit_email';

    protected $fillable =
        [
            'email',
            'token',
        ];
}
