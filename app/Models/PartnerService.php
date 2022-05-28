<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerService extends Model
{
    use HasFactory;

    protected $table = 'partner_service';
    
    protected $guarded = [
        'id'
    ];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
