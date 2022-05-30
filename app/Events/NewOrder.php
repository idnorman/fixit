<?php

namespace App\Events;

use App\Models\Partner;
use App\Models\PartnerService;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $transaction, $transactionDetail, $service, $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Transaction $transaction, TransactionDetail $transactionDetail, $service, $message)
    {
        $this->message           = $message;
        $this->user              = $user;
        $this->transaction       = $transaction;
        $this->transactionDetail = $transactionDetail;
        $this->service           = $service;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('partner.' . $this->transaction->partner_id);
    }
}
