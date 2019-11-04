<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopMagic;
class Shop extends Model
{
    //
    public function magics()
    {
        return $this->hasMany(ShopMagic::class);
    }
}
