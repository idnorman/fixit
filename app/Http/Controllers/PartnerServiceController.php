<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerService;
use App\Models\Service;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PartnerServiceController extends Controller
{

    use ApiResponser;

    public function index()
    {
        //
    }

    public function getAllServices(){
        $services = PartnerService::with('service')->get();
        return $this->success(['services' => $services]);
    }

    public function create()
    {
        $services = Service::select('id', 'name')->get();
        
        $id = auth()->user()->id;
        return $this->success(['services' => $services, 'user' => $id]);
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'price'         => 'required|numeric',
            'service_id'    => 'required'
        ]);
        
        $userId             = auth()->user()->id;
        $attr['partner_id'] = Partner::select('id')->where('user_id', $userId)->first()->id;

        $partnerService = PartnerService::create([
            'price'         => $attr['price'],
            'note'          => $request->note,
            'partner_id'    => $attr['partner_id'],
            'service_id'    => $attr['service_id']
        ]);

        return $this->success([
            'partner_service'   => $partnerService
        ], 'Layanan berhasil ditambah');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $attr = $request->validate([
            'price'         => 'required|numeric'
        ]);
        
        $partnerService = PartnerService::find($request->id);

        $partnerService->update([
            'price'    => $attr['price'],
            'note'     => $request->note
        ]);

        return $this->success([
            'partner_service'   => $partnerService
        ], 'Layanan berhasil diubah');
    }

    public function destroy($id)
    {
        //
    }
}
