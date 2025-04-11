<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductUserController extends Controller
{
    public function index($id)
    {
        if (is_numeric($id)) {
            $products = Product::select()->where('idCat', $id)->get();
            $category = Category::all();
            $categoryName = DB::table('categories')->where('idCat', $id)->get();
            return view('User.product', ['products' => $products, 'category' => $category, 'categoryName' => $categoryName]);
        } else {
            $categoryFist = Category::first();
            // $product = DB::table('products')->where('idCat', $id)->get();
            $idCatFirst = $categoryFist->idCat;
            $products = Product::select()->where('idCat', $idCatFirst)->get();
            // $id = $products->idCat;
            $category = Category::all();
            // $categoryName = DB::table('categories')->where('idCat', $id)->get();
            return view('User.ProductView', ['products' => $products, 'category' => $category]);
        }
    }
    public function getProductAjax()
    {
        try {
            $firstIdCat = Category::select('idCat')->first();
            $field = $_GET['field'] ?? 'idPro';
            $sort = $_GET['sort'] ?? 'desc';
            $idCat = ($_GET['category'] && is_numeric($_GET['category'])) ? $_GET['category'] : $firstIdCat->idCat;
            $product = Product::with('ImageProduct')->where('idCat', $idCat)->orderBy($field, $sort)->get();
            return ApiResponse::Error($product, 'Thành công', 'success', 200);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Có lỗi xảy ra !', 'error', 500);
        }
    }
    public function getDetail($id, $name)
    {
        try {
            $model = new Product();
            $product = $model->getDetailProductModel($id, $name);
            $productRelated = $model->getRelatedProduct($id);
            // dd($productRelated)
            return view("User.ProductDetailView", ['product' => $product, 'productRelated' => $productRelated]);
        } catch (Throwable $e) {
            return view("template.404_NOT_FOUND");
        }
    }
}
