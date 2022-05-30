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
            'user_id'       => $userId,
            'partner_service_id'    => $request->partner_service_id
        ]);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();
        
        $message = $transaction->user->name . " memesan layanan servis " . $transaction->partner_service->service->name;
        broadcast(new NewOrder($transaction, $message));

        return $this->success(['transaction' => $transaction]);
    }

    public function accept(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_accepted' => 'accepted']);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();

        $message = "Pesanan servis " . $transaction->partner_service->service->name . " telah diterima";
        broadcast(new StatusOrder($message, $transaction));
        return $this->success(['transaction' => $transaction], 'Permintaan anda diterima, kurir akan segera menuju lokasi');
    }

    public function reject(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_accepted' => 'accepted']);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();

        $message = "Pesanan servis " . $transaction->partner_service->service->name . " telah diterima";
        broadcast(new StatusOrder($message, $transaction));
        return $this->success(['transaction' => $transaction], 'Permintaan anda diterima, kurir akan segera menuju lokasi');
    }

    public function getTransaction($id){
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $id)->first();

        return $this->success(['transaction' => $transaction]);

    }

    public function getTransactionsByUser($id){
        $transactions = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('user_id', $id)->get();
        return $this->success(['transactions' => $transactions]);
    }


}
