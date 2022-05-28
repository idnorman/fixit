<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerService;
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

        return $this->success([], 'Data berhasil diubah');
    }

    public function getPartner($id){
        $partner = Partner::select('id', 'name', 'description', 'phone', 'address')->find($id);
        return $this->success(['partner' => $partner]);
    }

    public function getPartnersByService($id){

        $partners = Partner::with([
            'partner_service' => function($query) use($id){
                $query->select('id', 'price', 'partner_id', 'service_id')->where('service_id', $id);
            }, 
            'partner_service.service' => function($query){
                $query->select('id', 'name');
            },
            'user' => function($query){
                $query->select('id', 'name');
            }])
            ->select('id', 'name', 'user_id')
            ->get();

        return $this->success(['partners' => $partners]);
    }

}
