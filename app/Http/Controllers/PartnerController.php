<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

use App\Traits\ApiResponser;

class PartnerController extends Controller
{

    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $attr = $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|numeric'
        ]);

        $partner = Partner::updateOrCreate(
            [
                'user_id'       => auth()->user()->id],
            [
                'name'          => $attr['name'],
                'address'       => $attr['address'],
                'phone'         => $attr['phone'],
                'description'   => $request->description,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude
            ]
        );

        $user = User::find(auth()->user()->id);
        $user->update(['role' => 'partner']);

        return $this->success(['partner_id' => $partner->id], 'Data berhasil diubah');
    }

    public function getPartner($id){
        $partner = Partner::select('id', 'name', 'description', 'phone', 'address')->find($id);
        return $this->success(['partner' => $partner]);
    }

    public function getPartners(){
        $partners = Partner::all();
        return $this->success(['partners' => $partners]);
    }

    public function getPartnerByUser($id){
        // $partner = Partner::select('id', 'name', 'description', 'phone', 'address')->find($id);
        $partner = Partner::with('user')->where('partners.user_id', $id)->first();
        if($partner){
            return $this->success(['partner' => $partner]);
        }else{
            return $this->error("Partner tidak ditemukan", 404);
        }
        
    }

    public function getPartnersByService($id){
        
        $partners = PartnerService::with(["partner","service"])->whereHas('service',function ($query) use ($id){
                        $query->where('id',$id);
                    })->get();

        
        return $this->success(['partners' => $partners]);
    }

    public function getServicesByPartner($id){
        $services = Service::with([
            'partner_service' => function($query) use($id){
                $query->select('id', 'price', 'partner_id', 'service_id')->where('service_id', $id);
            }]);
        return $this->success(['services' => $services]);
    }

    public function getPartnerAndService($id1, $id2){
        $partner = Partner::with(
            [
                'partner_service' => function($query) use ($id2){
                    $query->where('service_id', $id2);
                },
                'partner_service.service'
            ])
            ->where('id', $id1)
            ->get();
        
        return $this->success(['partner' => $partner]);
    }

}
