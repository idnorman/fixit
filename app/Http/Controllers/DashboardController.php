<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Service;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponser;
    public function search($q){

        $partners = Partner::select('partners.name', 'partners.address', 'partners.description')->where('partners.name', 'LIKE', '%'.$q.'%')->orWhere('partners.address', 'LIKE', '%'.$q.'%');
        $results = Service::select('services.name')->where('services.name', 'LIKE', '%'.$q.'%')->union($partners)->get();
        return $this->success(['results' => $results]);
    }
}
