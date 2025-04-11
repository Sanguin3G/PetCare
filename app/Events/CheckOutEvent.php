<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckOutEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $Payment_Method;
    public $data;
    public function __construct($Payment_Method, $data)
    {
        $this->Payment_Method = $Payment_Method;
        $this->data = $data;
    }

}
