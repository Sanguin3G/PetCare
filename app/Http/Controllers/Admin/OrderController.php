<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    public function index()
    {
        $model = new Order();
        $Order = $model->getListInforOfOrder();
        return view('Admin.OrderView', ['Order' => $Order]);
    }
    // get detail order
    public function getDetailOrder(string $idOrder)
    {
        try {
            $model = new Order();
            $result = $model->detailOfOrder($idOrder);
            if ($result) {
                // return ApiResponse::Error($result, 'Success', 'success', 200);
                return view('Admin.DetailOrderView', ['order' => $result]);
            }
            return ApiResponse::Error(null, 'Error', 'error', 500);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    public function delivery(string $id)
    {
        try {
            $model = new Order();
            $result = $model->deliveryOrder($id);
            if ($result) {
                return ApiResponse::Success(null, 'Success', 'success', 200);
            }
            return ApiResponse::Error(null, 'Error', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', 500);
        }
    }
}
