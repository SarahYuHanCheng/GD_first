<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'currency_code',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
