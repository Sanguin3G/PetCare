<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistAccount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $email;
    public $OTP;
    public function __construct($email, $OTP)
    {
        $this->email = $email;
        $this->OTP = (int)$OTP;
    }
}
