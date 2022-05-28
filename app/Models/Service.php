<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    
    public function partner_service(){
        return $this->hasMany(PartnerService::class);
    }
}
