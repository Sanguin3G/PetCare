<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::orderBy('id', 'desc')->paginate(10);
        // $voucher->sortBy('id','desc');
        return view('Admin.VoucherView', ['voucher' => $voucher]);
    }
}
