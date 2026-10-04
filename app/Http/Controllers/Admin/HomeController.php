<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('Admin.HomeAdmin', [
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'pendingOrders' => Order::where('status', 0)->count(),
            'outOfStock' => Product::where('count', '<=', 0)->count(),
            'productCount' => Product::count(),
            'recentOrders' => Order::latest()->limit(5)->get(),
        ]);
    }
}
