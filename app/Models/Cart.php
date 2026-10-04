<?php
namespace App\Models;
use App\Jobs\ProcessCheckOut;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Cart extends Model
{
    public function CheckoutModel($request): Order
    {
        $order = DB::transaction(function () use ($request) {
            $items = collect($request->Cart);
            $products = Product::whereIn('idPro', $items->pluck('idPro'))->orderBy('idPro')->lockForUpdate()->get()->keyBy('idPro');
            foreach ($items as $item) {
                $product = $products->get($item['idPro']);
                if (!$product || $product->count < $item['count']) {
                    throw ValidationException::withMessages(['Cart' => ($product?->namePro ?? 'Sản phẩm') . ' không còn đủ số lượng. Vui lòng cập nhật giỏ hàng.']);
                }
            }
            $order = Order::create([
                'idCus' => Auth::id(), 'status' => 0, 'address' => $request->Address,
                'note' => trim($request->Name . ' · ' . $request->Phone . ($request->Note ? ' — ' . $request->Note : '')),
                'thanhtoan' => 'Thanh toán bằng phương thức COD',
            ]);
            foreach ($items as $item) {
                $product = $products->get($item['idPro']);
                OrderDetail::create([
                    'number' => $item['count'], 'idPro' => $product->idPro,
                    'price' => $product->cost, 'discount_snapshot' => max(0, min(100, (int) $product->discount)), 'idOrder' => $order->id,
                ]);
                $product->decrement('count', $item['count']);
            }
            return $order;
        });
        try {
            $details = DB::table('order_detail as o')->join('products as p', 'o.idPro', '=', 'p.idPro')
                ->where('o.idOrder', $order->id)->select('o.*', 'p.namePro', 'o.discount_snapshot as discount')->get();
            dispatch(new ProcessCheckOut(Auth::user()->email, [
                'Order' => $order, 'OrderDetail' => $details, 'totalPrice' => $order->getTotalCostOfOrder($order->id),
                'product' => $order, 'discountVoucher' => 0, 'id' => $order->id,
            ]));
        } catch (\Throwable $e) {
            // The order has committed; mail transport failure must not invite a duplicate order.
            Log::warning('Order confirmation could not be queued', ['order' => $order->id, 'exception' => $e]);
        }
        return $order;
    }
}
