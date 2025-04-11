<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CartController extends Controller
{
    public function index()
    {
        return view('User.CartView');
    }
    public function Checkout(Request $request)
    {
        // Log::info($request->all());
        // return response()->json(['data' => $request->all(), 'user' => Auth::user()]);
        try {
            $model = new Cart();
            $result = $model->CheckoutModel($request);
            if ($result) {
                return ApiResponse::Success(null, 'Vui lòng kiểm tra đơn hàng trong giỏ hàng', 'success', 200);
            } else {
                return ApiResponse::Error(null, 'Có lỗi xảy ra !', 'error', 500);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra !', 'error', 500);
        }
    }
}
