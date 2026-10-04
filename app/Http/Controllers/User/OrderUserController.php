<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class OrderUserController extends Controller
{
    public function getOrderList()
    {
        return view('User.OrderView', ['Order' => (new Order())->getListOrderUser(Auth::id()) ?? collect()]);
    }
    public function cancelOrder(string $id)
    {
        return DB::transaction(function () use ($id) {
            $order = Order::where('idCus', Auth::id())->where('id', $id)->lockForUpdate()->firstOrFail();
            if ((int) $order->status !== 0) {
                return response()->json(['message' => 'Chỉ có thể hủy đơn đang chờ xác nhận.'], 422);
            }
            foreach (OrderDetail::where('idOrder', $order->id)->orderBy('idPro')->get() as $item) {
                Product::where('idPro', $item->idPro)->increment('count', $item->number);
            }
            $order->update(['status' => -1]);
            return response()->json(['message' => 'Đã hủy đơn hàng.']);
        });
    }
}
