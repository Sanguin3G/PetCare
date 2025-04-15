<?php

namespace App\Listeners;

use App\Events\ForgetPassword;
use App\Jobs\SendOTPForgetPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ForgetPasswordListener
{
    public function handle(ForgetPassword $event): void
    {
        dispatch(new SendOTPForgetPassword($event->email, $event->OTP));
    }
}
