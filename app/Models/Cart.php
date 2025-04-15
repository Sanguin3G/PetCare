<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Voucher;
use App\Models\VoucherUser;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessCheckOut;

class Cart extends Model
{
    public function CheckoutModel($request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $id = $user->id;
            $paymentMethod = $request->Method_Payment;
            $emailCustomer = $user->email;
            $order = new Order();
            $order->idCus = $id;
            $order->status = 0;
            $order->address = $request->Address;
            $order->note = $request->Note;
            $order->thanhtoan = $paymentMethod;
            $order->created_at = now('Asia/Ho_Chi_Minh');
            if ($request->IdVoucher && $request->IdVoucher > 0) {
                $voucherUser = VoucherUser::find($request->input('idVoucher'));
                $voucherId = $voucherUser->id_voucher;
                $order->idVoucher = $voucherId;
            }
            if (!$request->IdVoucher && $request->IdVoucher <= 0) {
                $order->idVoucher = null;
            }
            $order->save();
            $idLatestOrder = $order->id;
            foreach ($request->Cart as $product) {
                $idPro = $product['idPro'];
                // thêm dữ liệu vào bảng orderdetail
                OrderDetail::create([
                    'number' => $product['count'],
                    'idPro' => $idPro,
                    'price' => $product['cost'],
                    'idOrder' => $idLatestOrder
                ]);
                // giảm số lượng sản phẩm
                $updatePro = product::find($idPro);
                $updatePro->count = $updatePro->count - $product['count'];
                // dd($pro->count - $row->number);
                $updatePro->update();
            }
            // Dùng voucher xong thì giảm số lượng voucher;
            if ($request->IdVoucher && $request->IdVoucher > 0) {
                $voucherUser = VoucherUser::find($request->IdVoucher);
                $soluong = $voucherUser->soluong;
                $voucherUser->soluong = $soluong - 1;
                $voucherUser->update();
            }
            if ($paymentMethod !== 'Thanh toán bằng VNPAY') {
                // tạo dữ liệu để truyền vào mail gửi thông báo
                $product = new Order();
                $totalPrice = (int)$request->Total;
                $OrderDetail = DB::table("order_detail as o")
                    ->join("products as p", "o.idPro", "=", "p.idPro")
                    ->where("o.idOrder", $idLatestOrder)
                    ->select('o.id', 'o.number', 'o.idPro', 'o.price', 'o.idOrder', 'p.idPro', 'p.namePro', 'p.cost', 'p.discount')->get();
                // $Order = Order::select()->where('id', 8)->get();
                $Order = Order::find($idLatestOrder);
                Log::info($OrderDetail);
                $discountVoucher = $request->DiscountVoucher;
                $dataOrder = [
                    'Order' => $Order,
                    'OrderDetail' => $OrderDetail,
                    'totalPrice' => $totalPrice,
                    'product' => $product,
                    'discountVoucher' => $discountVoucher,
                    'id' => $idLatestOrder
                ];
                dispatch(new ProcessCheckOut($emailCustomer, $dataOrder));
            }
            DB::commit();
            return true;
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
}
