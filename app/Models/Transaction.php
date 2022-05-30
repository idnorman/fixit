<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id'
    ];

    public function transaction_detail(){
        return $this->hasMany(TransactionDetail::class);
    }
}
