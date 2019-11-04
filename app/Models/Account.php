<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

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
    public function transactionHistory()
    {   
        $transactions = Transaction::where('payer',$this->id)->orwhere('payee',$this->id)->get();
        
        return $transactions;
    }
}
