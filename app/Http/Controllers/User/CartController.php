<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;
class CartController extends Controller
{
    public function index() { return view('User.CartView'); }
    public function quote(Request $request)
    {
        $request->validate(['ids' => 'required|array|max:100', 'ids.*' => 'required|string|max:10']);
        return response()->json(['data' => Product::with('ImageProduct')->whereIn('idPro', $request->ids)->get()->map(fn ($product) => [
            'idPro' => $product->idPro, 'name' => $product->namePro, 'cost' => $product->cost,
            'discount' => $product->discount, 'maxCount' => $product->count,
            'image' => asset('assets/img-add-pro/' . ($product->ImageProduct->first()?->image ?? '11744768508.webp')),
        ])]);
    }
    public function Checkout(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:100', 'Phone' => 'required|string|regex:/^[0-9+() .-]{8,20}$/',
            'Address' => 'required|string|max:255', 'Note' => 'nullable|string|max:150',
            'Method_Payment' => ['required', Rule::in(['cod', 'Thanh toán bằng phương thức COD'])],
            'Cart' => 'required|array|min:1|max:100', 'Cart.*.idPro' => 'required|string|distinct|max:10',
            'Cart.*.count' => 'required|integer|min:1|max:999', 'IdVoucher' => 'nullable|in:0',
        ]);
        try {
            $order = (new Cart())->CheckoutModel($request);
            return response()->json(['status' => 'success', 'message' => 'Đặt hàng thành công.', 'data' => ['id' => $order->id]]);
        } catch (ValidationException $e) { throw $e; }
        catch (Throwable $e) {
            Log::error('Checkout failed', ['exception' => $e]);
            return response()->json(['message' => 'Không thể đặt hàng lúc này. Vui lòng thử lại.'], 500);
        }
    }
}
