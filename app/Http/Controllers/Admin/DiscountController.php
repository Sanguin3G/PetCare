<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $category = new Category();
        $discount = Discount::paginate(10);
        $discount->sortBy('id');
        return view('Admin.DiscountView', ['discount' => $discount, 'category' => $category]);
    }
}
