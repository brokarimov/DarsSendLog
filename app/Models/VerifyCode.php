<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
    ];
}
