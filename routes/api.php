<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildServiceController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\VNPAYController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\GoogleController;

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\ProductUserController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;

Route::prefix('auth')->group(function () {
    Route::post('admin/login', [UserController::class, 'checkLogin']);
    Route::prefix('user')->group(function () {
        Route::get('account/regist', [CustomerController::class, 'RegistAccount']);
        Route::post('login', [UserController::class, 'checkLogin']);
        Route::post('register', [UserController::class, 'createAccountController']);
        Route::post('register/sendOTP', [UserController::class, 'sendOTPCreateAccountController']);
    });
    Route::prefix('admin')->group(function () {
        Route::post('register', [UserController::class, 'createAccountController']);
        Route::post('register/sendOTP', [UserController::class, 'sendOTPCreateAccountController']);
    });
});
Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post("cart/checkout", [CartController::class, 'Checkout']);
        Route::get('product', [ProductUserController::class, 'getProductAjax']);
        Route::post('account/logout', [CustomerController::class, 'Logout']);
    });
    Route::prefix('admin')->group(function () {
        Route::get('profile', [UserController::class, 'getUserProfile']);
        Route::post('logout', [UserController::class, 'Logout']);
        //tạo mới nhân viên
        Route::post('createStaff', [StaffController::class, 'store']);
        //tạo mới danh mục
        Route::post('category/create', [CategoryController::class, 'store']);
        Route::delete('category/delete', [CategoryController::class, 'delete']);
        Route::patch('category/update', [CategoryController::class, 'update']);
        //sản phẩm
        Route::get('product/get', [ProductController::class, 'indexAjax']);
        Route::post('product/create', [ProductController::class, 'store']);
        Route::delete('product/delete', [ProductController::class, 'delete']);
        Route::post('product/update/{id}', [ProductController::class, 'update']);
        Route::delete('product/image/delete', [ProductController::class, 'deleteImageProduct']);
        // service
        Route::post('service/create', [ServiceController::class, 'store']);
        Route::post('service/update', [ServiceController::class, 'update']);
    });
});
