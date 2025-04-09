<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\User\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class SendOTPRegisterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $OTP;
    public function __construct($email, $OTP)
    {
        $this->email = $email;
        $this->OTP = (int)$OTP;
    }
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            // xóa các otp trước đó
            DB::table('opt_regist_forget_account')
                ->where([
                    'email' => $this->email,
                    'type' => 'regist'
                ])
                ->delete();
            // thêm mã otp vào bảng
            DB::table('opt_regist_forget_account')->insert([
                'email' => $this->email,
                'OTP' => $this->OTP,
                'type' => 'regist',
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'expired_at' => Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(10)
            ]);
            Mail::send("template.SendOTPRegisterAccount", ['OTP' => $this->OTP], function ($message) {
                $message->to($this->email);
                $message->subject("PetCare - Đăng ký tài khoản");
            });
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Lỗi gửi email OTP đăng ký tài khoản: " . $e);
        }
    }
}
