<?php

namespace App\Jobs;

use Carbon\Traits\Serialization;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Illuminate\Support\Facades\Log;

class DeleteOldOTPJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;
    protected $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle(): void
    {
        try {
            DB::beginTransaction();
            DB::table('opt_regist_forget_account')
                ->where([
                    'email' => $this->email,
                    'type' => 'forget'
                ])
                ->delete();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }
    }
}
