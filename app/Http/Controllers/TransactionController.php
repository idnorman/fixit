<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Events\StatusOrder;
use App\Events\StatusPaid;
use App\Models\Partner;
use App\Models\PartnerService;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Notifications\NewTransaction;
use App\Traits\ApiResponser;
use App\Traits\Firebase;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponser, Firebase;
 
    public function create(Request $request){

        $userId         = auth()->user()->id;
        $datetime       = date('Y-m-d H:i:s');

        $transaction    = Transaction::create([
            'date'                  => $datetime,
            'user_id'               => $userId,
            'partner_service_id'    => $request->partner_service_id,
            'note'                  => $request->note,
            // 'partner_note'          => $request->partner_note,
            // 'customer_note'         => $request->customer_note,
            // 'waiting_note'          => $request->waiting_note,
            // 'accepted_note'         => $request->accepted_note,
            // 'rejected_note'         => $request->rejected_note,
            // 'finished_note'         => $request->finished_note
        ]);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();
        $transaction['intended_for'] = "partner";
        
        
        $message = $transaction->user->name . " memesan layanan servis " . $transaction->partner_service->service->name;

        $notification = [
            'title' =>'Pesanan baru',
            'body' => $message,
            'icon' =>'myIcon',
            'sound' => 'default'
        ];
        $extraNotificationData = [
            "message" => $notification,
            "moredata" => $transaction
        ];

        $token = User::with('device')->where('id', $transaction->partner_service->partner->user_id)->get()->pluck('device')->flatten();
        $tokenList = [];

        foreach($token as $t){
            array_push($tokenList, $t->token);
        }

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $this->firebaseNotification($fcmNotification);

        return $this->success(['transaction' => $transaction]);
    }    

    public function accept(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_accepted' => 'accepted']);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();
        $transaction['intended_for'] = "customer";

        $message = "Booking reparasi " . $transaction->partner_service->service->name . " telah diterima penyedia jasa. Ketuk untuk melihat rincian";
        
        $notification = [
            'title' =>'Pesanan diterima',
            'body' => $message,
            'icon' =>'myIcon',
            'sound' => 'default'
        ];
        $extraNotificationData = [
            "message" => $notification,
            "moredata" => $transaction
        ];
        
        $token = User::with('device')->where('id', $transaction->user->id)->get()->pluck('device')->flatten();
        $tokenList = [];
        
        foreach($token as $t){
            array_push($tokenList, $t->token);
        }

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $this->firebaseNotification($fcmNotification);

        return $this->success(['transaction' => $transaction], $message);
    }

    public function reject(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_accepted' => 'rejected']);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();
        $transaction['intended_for'] = "customer";

        $message = "Pesanan reparasi " . $transaction->partner_service->service->name . " ditolak. Permintaan anda telah dibatalkan";
        $notification = [
            'title' =>'Pesanan ditolak',
            'body' => $message,
            'icon' =>'myIcon',
            'sound' => 'default'
        ];
        $extraNotificationData = [
            "message" => $notification,
            "moredata" => $transaction
        ];

        $token = User::with('device')->where('id', $transaction->user->id)->get()->pluck('device')->flatten();
        $tokenList = [];

        foreach($token as $t){
            array_push($tokenList, $t->token);
        }
        
        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $this->firebaseNotification($fcmNotification);
        return $this->success(['transaction' => $transaction], $message);
    }

    public function finish(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_accepted' => 'finished']);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();
        $transaction['intended_for'] = "customer";

        $message = "Pesanan reparasi " . $transaction->partner_service->service->name . " telah selesai. terimakasih";
        $notification = [
            'title' =>'Pesanan selesai',
            'body' => $message,
            'icon' =>'myIcon',
            'sound' => 'default'
        ];
        $extraNotificationData = [
            "message" => $notification,
            "moredata" => $transaction
        ];

        $token = User::with('device')->where('id', $transaction->user->id)->get()->pluck('device')->flatten();
        $tokenList = [];

        foreach($token as $t){
            array_push($tokenList, $t->token);
        }

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $this->firebaseNotification($fcmNotification);
        return $this->success(['transaction' => $transaction], $message);
    }

    public function paid(Request $request){
        $transaction = Transaction::find($request->transaction_id);
        $transaction->update(['is_paid' => '1']);
        
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $transaction->id)->first();

        $message = "Pesanan reparasi " . $transaction->partner_service->service->name . " telah dibayar. Terimakasih";
        $notification = [
            'title' =>'Status Pembayaran',
            'body' => $message,
            'icon' =>'myIcon',
            'sound' => 'default'
        ];
        $extraNotificationData = [
            "message" => $notification,
            "moredata" => $transaction
        ];

        $token = User::with('device')->where('id', $transaction->user->id)->get()->pluck('device')->flatten();
        $tokenList = [];

        foreach($token as $t){
            array_push($tokenList, $t->token);
        }

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $this->firebaseNotification($fcmNotification);
        return $this->success(['transaction' => $transaction], $message);
    }

    public function getTransaction($id){
        $transaction = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('id', $id)->first();

        return $this->success(['transaction' => $transaction]);

    }

    public function getTransactionsByUser($id){
        $transactions = Transaction::with('user', 'partner_service.partner', 'partner_service.service')->where('user_id', $id)->orderBy('id', 'desc')->get();
        return $this->success(['transactions' => $transactions]);
    }

    public function getTransactionsByPartner($id){

        $transactions = Transaction::whereHas('partner_service', function ($q) use ($id){
            $q->whereHas('partner', function($q) use ($id){
                $q->where('id', $id);
            });
        })->with('partner_service.partner.user', 'partner_service.service', 'user')->orderBy('id', 'desc')->get();

        return $this->success(['transactions' => $transactions]);
    }


}
