<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;


class ProcessCheckOut implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $order;
    public function __construct($email, $order)
    {
        $this->email = $email;
        $this->order = $order;
    }
    public function handle(): void
    {
        try {
            Mail::send("template.SuccessfullOrder", [
                'Order' => $this->order['Order'],
                'OrderDetail' => $this->order['OrderDetail'],
                'totalPrice' => $this->order['totalPrice'],
                'product' => $this->order['product'],
                'discountVoucher' => $this->order['discountVoucher'],
                'id' => $this->order['id']
            ], function ($message) {
                $message->to($this->email);
                $message->subject("Thông báo đặt hàng thành công !");
            });
        } catch (Exception $e) {
            // Log::error('Có lỗi xảy ra' . $e);
            Log::error('Có lỗi xảy ra' . $e->getMessage());
        }
    }
}
