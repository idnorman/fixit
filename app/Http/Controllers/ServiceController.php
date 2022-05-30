<?php

namespace App\Http\Controllers;

use App\Models\PartnerService;
use App\Models\Service;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponser;
    public function getServicesByPartner($id){
        $services = PartnerService::with('service')->select('service_id', 'partner_id', 'price', 'id')->where('partner_id', $id)->groupBy('service_id', 'partner_id', 'price', 'id')->get();

        return $this->success(['services' => $services]);
    }
    

}
