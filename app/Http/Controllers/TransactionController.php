<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Events\StatusOrder;
use App\Models\Partner;
use App\Models\PartnerService;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Notifications\NewTransaction;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponser;
 
    public function create(Request $request){

        $userId         = auth()->user()->id;
        $datetime       = date('Y-m-d H:i:s');
        $transaction    = Transaction::create([
            'date'          => $datetime,
            'location'      => $request->location,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'user_id'       => $userId,
            'partner_id'    => $request->partner_id
        ]);

        $transactionDetail = TransactionDetail::create([
            'transaction_id'        => $transaction->id,
            'partner_service_id'    => $request->partner_service_id
        ]);

        $service = PartnerService::with('service')->where('id', $request->partner_service_id)->first();
        $transaction = Transaction::with('transaction_detail.partner_service.service')->where('id', $transaction->id)->first();
        $user = User::find($userId);
        
        $message = $user->name . " memesan layanan servis " . $service->service->name;
        broadcast(new NewOrder($user, $transaction, $transactionDetail, $service, $message));
        // $partner->notify(new NewTransaction($user, $transaction, $transactionDetail, $service, $message));

        return $this->success(['transaction' => $transaction]);
    }

    public function accept(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_accepted' => 'accepted']);
        
        $transaction = Transaction::with('transaction_detail.partner_service.service')->where('id', $transaction->id)->first();

        $message = "Pesanan servis " . $transaction->transaction_detail[0]->partner_service->service->name . " telah diterima";
        // broadcast(new StatusOrder($message, $transaction));
        return $this->success(['transaction' => $transaction], 'Permintaan anda diterima, kurir akan segera menuju lokasi');
    }

    public function reject(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_rejected' => 'rejected']);

        return $this->success(['transaction' => $transaction], 'Permintaan anda ditolak');
    }

    public function getTransaction($id){
        $transaction = Transaction::with('transaction_detail')->where('id', $id)->first();

        return $this->success(['transaction' => $transaction]);

    }


}
