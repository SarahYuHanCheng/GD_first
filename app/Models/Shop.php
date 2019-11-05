<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ShopMagic;
class Shop extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'user_id',
    ];
    
    protected $dates = ['deleted_at'];

    public function magics()
    {
        return $this->hasMany(ShopMagic::class);
    }
}
