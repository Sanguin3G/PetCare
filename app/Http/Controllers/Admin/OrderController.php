<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    protected $Order;
    public function __construct(Order $order)
    {
        $this->Order = $order;
    }
    public function index()
    {
        $Order = $this->Order->getListInforOfOrder();
        return view('Admin.OrderView', ['Order' => $Order]);
    }
    /**
     * get detail order
     * @param string $idOrder
     * @return ApiResponse|view
     */
    public function getDetailOrder(string $idOrder)
    {
        try {
            $result = $this->Order->detailOfOrder($idOrder);
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
    /**
     * get detail order
     * @param string $idOrder
     * @return ApiResponse
     */
    public function delivery(string $id): JsonResponse
    {
        try {
            $result = $this->Order->deliveryOrder($id);
            if ($result) {
                return ApiResponse::Success(null, 'Success', 'success', 200);
            }
            return ApiResponse::Error(null, 'Error', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', 500);
        }
    }
}
