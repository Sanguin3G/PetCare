<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ListProductCollection;

class ProductController extends Controller
{
    public function index()
    {
        $model = new Product();
        $products = $model->getListproduct();
        return view('Admin.ProductView', [
            'product' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(), // total pages
            'total' => $products->total(), // // total product
            'per_page' => $products->perPage(),
        ]);
    }
    public function indexAjax(Request $request)
    {
        try {
            $products = Product::with('ImageProduct')->orderBy('idPro', 'desc')->paginate(5);
            return new ListProductCollection($products);
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    public function create()
    {
        $model = new Product();
        $category = $model->getListCategory();
        return view('Admin.CreateProductView', ['category' => $category]);
    }
    public function store(Request $request)
    {
        try {
            $model = new Product();
            $result = $model->StoreProductModel($request);
            if ($result) {
                return ApiResponse::Success(null, "Thêm sản phẩm thành công", 'success', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    public function edit($id, $name)
    {
        $model = new Product();
        $result = $model->editModel($id, $name);
        return view('Admin.ChangeProductView', ['product' => $result['product'], 'category' => $result['category'], 'nameCat' => $result['nameCat']]);
    }
    public function delete(Request $request)
    {
        try {
            $model = new Product();
            $result = $model->deleteModel($request);
            if ($result) {
                return ApiResponse::Success(null, "Xóa sản phẩm thành công", 'success', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    public function update(string $id, Request $request)
    {
        try {
            $model = new Product();
            Log::info($request);
            $result = $model->updateModel($id, $request);
            if ($result === 'success') {
                return ApiResponse::Success(null, "Cập nhật sản phẩm thành công", 'success', 200);
            }
            if ($result === 'Not Found') {
                return ApiResponse::Success(null, "Not Found", 'error', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    public function deleteImageProduct(Request $request)
    {
        try {
            $model = new Product();
            $result = $model->deleteImageProductModel($request);
            if ($result) {
                return ApiResponse::Success(null, "Xóa ảnh thành công", 'success', 200);
            } else {
                return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
        }
    }
}
