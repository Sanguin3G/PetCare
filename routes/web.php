<?php

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
use App\Http\Controllers\User\OrderUserController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\HomeUserController;
use App\Http\Controllers\User\ProductUserController;

//Login Google
// Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('loginGoogle');
// Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('callback');
//user view
Route::get('pdf', function () {
    return view('template.BillTemplate');
});
Route::prefix('')->group(function () {
    Route::get('orderUser/cancel/{id}', [OrderUserController::class, 'cancelOrder'])->name('user.deleteOrder');
    //phải đăng nhập mới được truy cập
    //infor user
    Route::get('infor', [UserController::class, 'inforUser'])->name('user.infor');
    //Change pass
    Route::get('changePass', [UserController::class, 'changePassForm'])->name('user.changePassForm');
    //follow orrder
    Route::get('orderUser', [OrderUserController::class, 'index'])->name('user.orderView');
    //forget pass
    Route::get('forgetPass', function () {
        return view('User.ForgetPasswordView');
    })->name('user.forgetPass');
    Route::post('forgetPass', [UserController::class, 'forgetPass'])->name('user.sendEmail');
    Route::get('resetPassView/{token}', [UserController::class, 'Notification'])->name('user.LoadResetPassView');
    Route::post('resetPass', [UserController::class, 'resetPassword'])->name('user.resetPass');
    Route::get('login', [CustomerController::class, 'Login'])->name('user.login');
    Route::get('register', [CustomerController::class, 'Register'])->name('user.register');
    // Route::post('registerUser', [UserController::class, 'register'])->name('user.registAccount');
    Route::get('/', [HomeUserController::class, 'index'])->name('user.home');
    Route::get('about', function () {
        return view('User.AboutView');
    })->name('user.about');
    Route::get('service', [ServiceController::class, 'index'])->name('user.service');
    //product
    // Route::get('product/nam', [ProductUserController::class, 'SortProduct'])->name('user.sort');
    Route::get('contact', function () {
        return view('User.contact');
    })->name('user.contact');
    //Cart
    Route::get('cart', [CartController::class, 'index'])->name('user.cart');
    Route::get('product/detail/{id}/{name}', [ProductUserController::class, 'getDetail'])->name('user.productDetail');
    Route::get('product/{id}', [ProductUserController::class, 'index'])->name('user.product');
});
//admin view
// Routes không yêu cầu xác thực
Route::get('admin/login', function () {
    return view('Admin.LoginView');
})->name('admin.login');

Route::get('admin/register', function () {
    return view('Admin.RegisterView');
})->name('admin.regist');

// Routes yêu cầu xác thực (admin)
Route::prefix('admin')->group(function () {

    // Trang chủ
    Route::get('', [HomeController::class, 'index'])->name('admin.home');

    // Profile
    Route::get('profile', [UserController::class, 'profile'])->name('admin.profile');

    // Logout
    Route::get('logout', [UserController::class, 'logOut'])->name('admin.logout');

    // Quản lý sản phẩm
    Route::get('product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('product/add', [ProductController::class, 'create'])->name('admin.addForm');
    Route::get('product/change/{id}/{name}', [ProductController::class, 'edit'])->name('admin.changeProductView');

    // Quản lý danh mục
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('category/add', [CategoryController::class, 'create'])->name('admin.categoryForm');

    // Quản lý đơn hàng
    Route::get('order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('order/detail/{id}', [OrderController::class, 'detail'])->name('admin.detail');
    Route::get('order/delivery/{id}', [OrderController::class, 'delivery'])->name('admin.delivery');
});
Route::get('permit', function () {
    return view('template.Permit_Access');
});
Route::get('/{any}', function () {
    return view('template.404_NOT_FOUND');
})->where('any', '.*');
