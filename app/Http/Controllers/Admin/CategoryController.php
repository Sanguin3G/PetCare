<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Throwable;

class CategoryController extends Controller
{
    protected $model;
    public function __construct(Category $category)
    {
        $this->model = $category;
    }
    public function index()
    {
        $category = Category::paginate(10);
        return view('Admin.CategoryView')->with('category', $category);
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->model->createCategory($request);
            if (is_array($result)) {
                return ApiResponse::Error($result, 'Thêm danh mục thành công', 'success', 200);
            }
            if ($result == 'Category has existed !') {
                return ApiResponse::Success($result, 'Danh mục đã tồn tại !', 'error', 200);
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
    public function delete(Request $request): JsonResponse
    {
        try {
            $result = $this->model->deleteCategory($request);
            if ($result == 'true') {
                return ApiResponse::Success(null, "Xóa danh mục thành công", 'success', 200);
            }
            if ($result == 'Not Found') {
                return ApiResponse::Success(null, "Danh mục không tồn tại", 'error', 200);
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
    public function update(Request $request): JsonResponse
    {
        try {
            $result = $this->model->updateCategory($request);
            if ($result === 'success') {
                return ApiResponse::Success(null, "Cập nhật danh mục thành công", 'success', 200);
            }
            if ($result === 'Not Found') {
                return ApiResponse::Success(null, "Danh mục không tồn tại", 'error', 200);
            }
            if ($result === 'Name has existed') {
                return ApiResponse::Success(null, "Danh mục đã tồn tại", 'error', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', 500);
        }
    }
}
