<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class ShopMagic extends Model
{
    protected $fillable = [
        'shop_id', 'magic_id',
    ];
}
