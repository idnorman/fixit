<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function partner_service(){
        return $this->belongsTo(PartnerService::class);
    }
}
