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
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function index()
    {
        $products = $this->product->getListproduct();
        return view('Admin.ProductView', [
            'product' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(), // total pages
            'total' => $products->total(), // // total product
            'per_page' => $products->perPage(),
        ]);
    }
    /**
     * @param Request $request 
     * @return ListProductCollection|null 
     */
    public function indexAjax(Request $request): ListProductCollection|null
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
        $category = $this->product->getListCategory();
        return view('Admin.CreateProductView', ['category' => $category]);
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->product->StoreProductModel($request);
            if ($result) {
                return ApiResponse::Success(null, "Thêm sản phẩm thành công", 'success', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    /**
     * @param string $id
     * @param string $name
     * @return view
     */
    public function edit(string $id, string $name)
    {
        $result = $this->product->editModel($id, $name);
        return view('Admin.ChangeProductView', ['product' => $result['product'], 'category' => $result['category'], 'nameCat' => $result['nameCat']]);
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $result = $this->product->deleteModel($request);
            if ($result) {
                return ApiResponse::Success(null, "Xóa sản phẩm thành công", 'success', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $result = $this->product->updateModel($id, $request);
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

    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function deleteImageProduct(Request $request): JsonResponse
    {
        try {
            $result = $this->product->deleteImageProductModel($request);
            if ($result) {
                return ApiResponse::Success(null, "Xóa ảnh thành công", 'success', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
        }
    }
    /**
     * @param Request $request
     * @return ApiResponse|ListProductCollection
     */
    public function findProductByName(Request $request): JsonResponse|ListProductCollection
    {
        try {
            $result = $this->product->getListProductByName($request->text);
            Log::info($result);
            return new ListProductCollection($result);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', 500);
        }
    }
}
