<?php

namespace App\Listeners;

use App\Events\RegistAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendOTPRegisterJob;

class SendOTPConfirmToEmail
{
    public function handle(RegistAccount $event): void
    {
        dispatch(new SendOTPRegisterJob($event->email, $event->OTP));
    }
}
