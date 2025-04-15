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

class SendOTPForgetPassword implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;
    protected $email;
    protected $OTP;
    public function __construct($email, $OTP)
    {
        $this->email = $email;
        $this->OTP = $OTP;
    }

    public function handle(): void
    {
        try {
            DB::beginTransaction();
            // xóa các otp trước đó
            DB::table('opt_regist_forget_account')
                ->where([
                    'email' => $this->email,
                    'type' => 'forget'
                ])
                ->delete();
            // thêm mã otp vào bảng
            DB::table('opt_regist_forget_account')->insert([
                'email' => $this->email,
                'OTP' => $this->OTP,
                'type' => 'forget',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'expired_at' => Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(10)
            ]);
            Mail::send("template.SendOTPForgetpassword", ['OTP' => $this->OTP], function ($message) {
                $message->to($this->email);
                $message->subject("PetCare - Yêu cầu đặt lại mật khẩu");
            });
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Lỗi gửi email OTP đặt lại mật khẩu cho email : " . $this->email . "Message" . $e);
        }
    }
}
