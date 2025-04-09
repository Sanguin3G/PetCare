<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Throwable;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $model = new Product();
        $products = $model->getListproduct();

        return view('Admin.ProductView', [
            'product' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(), // Tổng số trang
            'total' => $products->total(), // Tổng số sản phẩm
            'per_page' => $products->perPage(),
        ]);
    }
    public function indexAjax(Request $request)
    {
        // $model = new Product();
        // $product = $model->getListproductAjax($request);
        try {
            $products = Product::with('ImageProduct')->orderBy('idPro', 'desc')->paginate(10);
            // return response()->json([
            //     'products' => $products->items(), // Dữ liệu sản phẩm trên trang hiện tại
            //     'pagination' => (string) $products->links('pagination::bootstrap-5'), // HTML phân trang
            // ]);
            return response()->json($products);
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
        // return response()->json($request);
        try {
            $model = new Product();
            $result = $model->StoreProductModel($request);
            if ($result === true) {
                return ApiResponse::Success(null, "Thêm sản phẩm thành công", 'success', 200);
            } else {
                return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
            }
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
            if ($result === true) {
                return ApiResponse::Success(null, "Xóa sản phẩm thành công", 'success', 200);
            } else {
                return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    public function update(Request $request)
    {
        return response()->json($request);
    }
    public function deleteImageProduct(Request $request)
    {
        try {
            $model = new Product();
            $result = $model->deleteImageProductModel($request);
            if ($result === true) {
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
