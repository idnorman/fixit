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

use App\Traits\Firebase;

class DashboardController extends Controller
{
    use ApiResponser, Firebase;

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

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
        $token="eWeZ3-OKRJG31_HqHGAR1y:APA91bEO863wBvgPQaCJb6CbKDAKINmz_M_-9oya9dV1xIM2kIpWUDFqPau1K-oH11t9Kd9SVP0R18CZ2BpVCa1TJlzb7fqTMjYk_G4CpMApbuRXLzo2txfDyJh-c3Vpml1bh4FVjaeB";
        $notification = [
            'title' =>'Ada orang pesan makanan bro',
            'body' => 'Makanan gannn',
            'icon' =>'myIcon',
            'sound' => 'default'
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];
        
        return $this->firebaseNotification($fcmNotification); 
    }

    public function storeToken(Request $request)
    {
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    public function test2(Request $request){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken =  "eWeZ3-OKRJG31_HqHGAR1y:APA91bEO863wBvgPQaCJb6CbKDAKINmz_M_-9oya9dV1xIM2kIpWUDFqPau1K-oH11t9Kd9SVP0R18CZ2BpVCa1TJlzb7fqTMjYk_G4CpMApbuRXLzo2txfDyJh-c3Vpml1bh4FVjaeB";
        
          
        $serverKey = 'AAAAbA2Bo14:APA91bHWsPmlVhmX_V6us2PlvdHgQCJyn1cDWYg-0AH1-C4GGOLUozA6TjivHV66mVZmP0GwKq9Xm3KY9GY5Uh9G6foTKc5h2v9X6_Jg95k96s2smMJ0xphxdOQCq3lXfBDgaK7gA6FV';

        $data = [
            "to" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        // dd($result);  
        return $result;      
    }

    public function get(){
        
    }
}
