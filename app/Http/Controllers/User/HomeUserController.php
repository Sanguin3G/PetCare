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
        $product = Product::with('ImageProduct')->where('count', '>', 0)->orderByDesc('hot')->latest()->limit(8)->get();
        return view('User.HomeView', compact('product'));
    }
   
}
