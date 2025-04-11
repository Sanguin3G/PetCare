<?php

namespace App\Listeners;

use App\Events\CheckOutEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckOutListener
{

    public function __construct()
    {
        //
    }
    public function handle(CheckOutEvent $event): void
    {
        //
    }
}
