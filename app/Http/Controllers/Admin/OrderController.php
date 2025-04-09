<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $Order = Order::orderBy('id', 'desc')->paginate(10);
        return view('Admin.OrderView', ['Order' => $Order]);
    }
}
