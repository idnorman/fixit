<?php

namespace App\Events;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message, $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($message, Transaction $transaction)
    {
        $this->message     = $message;
        $this->transaction = $transaction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('customer.'.$this->transaction->user_id);
    }

    public function broadcastAs()
    {
        return 'status-order';
    }
}
