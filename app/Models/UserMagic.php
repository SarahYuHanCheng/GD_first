<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserMagic extends Model
{
    protected $fillable = [
        'user_id', 'magic_id',
    ];
}
