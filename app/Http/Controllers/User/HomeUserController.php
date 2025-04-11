<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeUserController extends Controller
{
    public function index()
    {
        $post = Post::paginate(4);
        // $voucherDetail = new VoucherUser();
        // $voucher = Voucher::all()->where('status', '=', 1);
        $product = product::select()->where('count', '>', 0)->get();
        $voucherUserList = DB::table('voucher_users')->join('vouchers', 'voucher_users.id_voucher', '=', 'vouchers.id')->select('voucher_users.id', 'vouchers.time_end')->get();
        // dd($voucherUserList);
        $currentDate = now('Asia/Ho_Chi_Minh');
        // dd($currentDate);
        // foreach ($voucherUserList as $row) {
        //     if ($row->time_end < $currentDate) {
        //         $voucherDetail->updateVoucherUser($row->id);
        //     }
        // }
        // $imgProduct = $product->getImgProduct();
        return view('User.HomeView', ['product' => $product, 'post' => $post]);
    }
   
}
