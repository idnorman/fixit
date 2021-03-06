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


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function partner_service(){
        return $this->belongsTo(PartnerService::class);
    }
}
