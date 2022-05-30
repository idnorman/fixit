<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Models\Partner;
use App\Models\PartnerService;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewBook;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponser;
    public function search($q){
    
        $partners = Partner::select('id','name')->where('name','LIKE','%'.$q.'%')->get();
        $services = Service::select('id','name')->where('name','LIKE','%'.$q.'%')->get();
        $serviceWithPartner = Service::with(
            [
                'partner_service' => function($query){
                    $query->select('*')->get();
                },
                'partner_service.partner' => function($query) use ($q){
                    $query->select('id', 'name', 'address')
                        ->where('name','LIKE','%'.$q.'%')
                        ->orWhere('address', 'LIKE', '%'.$q.'%')
                        ->get();
                }
                
            ])->get();
        $partnerWithServices = PartnerService::with(
            ['partner' => function($query) use ($q){
                $query->select('id', 'name')->where('name','LIKE','%'.$q.'%');
            }, 
            'service' => function($query) use ($q){
                $query->select('id', 'name')->where('name','LIKE','%'.$q.'%');
            }])
            ->get();
        return $this->success(
            [
                'partners' => $partners, 
                'services' => $services, 
                'partnerWithServices' => $partnerWithServices,
                'serviceWithPartner' => $serviceWithPartner
            ]);
    }

    public function test(){
        $tes = PartnerService::with('partner', 'service')->select('id', 'price', 'partner_id', 'service_id')->where('service_id', 1)->groupBy('id', 'price', 'partner_id', 'service_id')->get();

        
        // $tes = $tes->partner_service->where('service_id', 2);
        
        // $user->notify(new NewBook($user));
        // broadcast(new NewOrder($user));
        // event(new NewOrder($user));	
        return $this->success(['tes' => $tes]);
    }
}
