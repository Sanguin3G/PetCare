<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderUserCollection;

class OrderUserController extends Controller
{
    public function getOrderList()
    {
        $idCus = Auth::user()->id;
        $model = new Order();
        $Order = $model->getListOrderUser($idCus);
        return view('User.OrderView', ['Order' => $Order]);
        // return new OrderUserCollection(($Order));
        // return response()->json($Order);
    }
}
