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

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CustomerController;
//Login Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('loginGoogle');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('callback');
//user view
Route::get('pdf', function () {
    return view('template.BillTemplate');
});
Route::prefix('')->group(function () {
    //phải đăng nhập mới được truy cập
    Route::middleware('checkLoginUser')->group(function () {
        //infor user
        Route::get('infor', [UserController::class, 'inforUser'])->name('user.infor');
        Route::PUT('infor/{id}', [UserController::class, 'updateInfor'])->name('user.updateInfor');
        //Change pass
        Route::get('changePass', [UserController::class, 'changePassForm'])->name('user.changePassForm');
        Route::put('changePass', [UserController::class, 'ChangePass'])->name('user.changePass');
        //log out
        Route::get('logout', [UserController::class, 'logOut'])->name('user.logout');
        //booking
        Route::post('book', [BookingController::class, 'store'])->name('user.bookCreate');
        //cart checkout
        Route::post('cart/checkout', [CartController::class, 'confirmCheckOut'])->name('user.confirmCheckOut');
        //follow orrder
        Route::get('order', [OrderController::class, 'index'])->name('user.orderView');
        Route::put('order/updateBook/{id}', [BookingController::class, 'update'])->name('user.updateBooking');
        Route::get('order/destroyBook/{id}', [BookingController::class, 'destroy'])->name('user.destroyBook');
        Route::get('saveVoucher/{id}', [VoucherController::class, 'store'])->name('user.saveVoucher');
        // cart
        Route::post('cart/addPro/{id}', [CartController::class, 'add'])->name('user.add');
        Route::get('cart/destroy', [CartController::class, 'destroyCart'])->name('user.destroyCart');
        Route::post('cart/update', [CartController::class, 'update'])->name('user.cartupdate');
        Route::get('cart/delete/{id}', [CartController::class, 'delete'])->name('user.delete');
        Route::get('cart/voucher', [CartController::class, 'useVoucher'])->name('user.useVoucher');
        // thanh toán VN_PAY
        Route::get('vn_pay/index', function () {
            return view('VN_PAY.index');
        });
        Route::get('vn_pay/vnpay_create_payment', [VNPAYController::class, 'createPayment'])->name('vnpay.createPayment');
        Route::get('vn_pay/vnpay_ipn', [VNPAYController::class, 'vnpay_ipn'])->name('vnpay.vnpay_ipn');
        Route::get('vn_pay/vnpay_pay', function () {
            return view('VN_PAY.vnpay_pay');
        });
        Route::get('vn_pay/vnpay_querydr', function () {
            return view('VN_PAY.vnpay_querydr');
        });
        Route::get('vn_pay/vnpay_refund', function () {
            return view('VN_PAY.vnpay_refund');
        });
        Route::get('vn_pay/vnpay_return', [CartController::class, 'saveOrderVnpay'])->name('vnpay.saveOrderToDB');
        // hủy đơn hàng
        Route::get('orderUser/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('user.deleteOrder');
    });
    // xem bài viết
    Route::get('post/{id}/{name}', [PostController::class, 'detail'])->name('user.detailPost');
    //forget pass
    Route::get('forgetPass', [UserController::class, 'index'])->name('user.forgetPass');
    Route::post('forgetPass', [UserController::class, 'forgetPass'])->name('user.sendEmail');
    Route::get('resetPassView/{token}', [UserController::class, 'Notification'])->name('user.LoadResetPassView');
    Route::post('resetPass', [UserController::class, 'resetPassword'])->name('user.resetPass');

    Route::get('loginUser', [UserController::class, 'index'])->name('user.login');
    // Route::post('login', [UserController::class, 'login'])->name('user.checkAccount');
    Route::post('loginUser', [UserController::class, 'loginCheck'])->name('user.checkLogin');

    Route::get('registerUser', [UserController::class, 'registerForm'])->name('user.register');
    Route::post('registerUser', [UserController::class, 'register'])->name('user.registAccount');

    Route::get('/', function () {
        return view('User.HomeView');
    })->name('user.home');
    Route::get('about', function () {
        return view('User.about');
    })->name('user.about');
    Route::get('service', [ServiceController::class, 'index'])->name('user.service');
    //product
    Route::get('product/{id}', [ProductController::class, 'index'])->name('user.product');
    // Route::get('product/{id}', [ProductUserController::class, 'getProduct'])->name('user.getPro');
    Route::get('product/detail/{id}/{name}', [ProductController::class, 'getDetail'])->name('user.productDetail');
    Route::get('sort', [ProductController::class, 'Product'])->name('user.sortproduct');
    // Route::get('product/nam', [ProductUserController::class, 'SortProduct'])->name('user.sort');

    //comment
    Route::post('product/detail/{id}', [CommentController::class, 'store'])->name('user.comment');
    //booking
    Route::get('book/{id}', [BookingController::class, 'index'])->name('user.book');
    // json lấy danh sách các gói dịch vụ
    Route::get('service/childs/getAll/{idService}/{typePet}', [ServiceController::class, 'getChildServiceController'])->name('use.getJsonListChildService');
    //contact
    Route::get('contact', function () {
        return view('User.contact');
    })->name('user.contact');
    //Cart
    Route::get('cart', [CartController::class, 'index'])->name('user.cart');
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
    /*
    |-------------------------------------------------
    | GET Routes
    |-------------------------------------------------
    */
    // Trang chủ
    Route::get('', [HomeController::class, 'index'])->name('admin.home');

    // Profile
    Route::get('profile', [UserController::class, 'profile'])->name('admin.profile');

    // Logout
    Route::get('logout', [UserController::class, 'logOut'])->name('admin.logout');

    // Quản lý bài viết
    Route::get('post', [PostController::class, 'index'])->name('admin.posts');
    Route::get('post/createView', [PostController::class, 'createView'])->name('admin.createposts');
    Route::get('post/detail/{id}', [PostController::class, 'Detail'])->name('admin.detailposts');
    Route::get('post/changeView/{id}/{name}', [PostController::class, 'changePostView'])->name('admin.changePostView');

    // Quản lý lịch làm việc
    Route::get('ListSchedule', [ScheduleController::class, 'index'])->name('admin.ListScheduleRoleStaff');
    Route::get('staff/schedule/regist', [ScheduleController::class, 'create'])->name('admin.registerScheduleView');
    Route::get('staff/schedule/detail/{id}', [ScheduleController::class, 'getDetailSchedule'])->name('admin.detailSchedule');

    // Quản lý sản phẩm
    Route::get('product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('product/add', [ProductController::class, 'create'])->name('admin.addForm');
    Route::get('product/change/{id}/{name}', [ProductController::class, 'edit'])->name('admin.changeProductView');

    // Quản lý danh mục
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('category/add', [CategoryController::class, 'create'])->name('admin.categoryForm');

    // Quản lý dịch vụ
    Route::get('service', [ServiceController::class, 'index'])->name('admin.service');
    Route::get('service/add', [ServiceController::class, 'create'])->name('admin.serviceAddView');
    Route::get('service/change/{id}', [ServiceController::class, 'edit'])->name('admin.change');
    Route::get('services/child/get/{id}', [ServiceController::class, 'getChildServiceController'])->name('admin.getChildService');
    Route::get('services/child/getPage/{id}', [ServiceController::class, 'getChildServiceByPage'])->name('admin.getChildServiceByPage');

    // Quản lý đơn hàng
    Route::get('order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('order/detail/{id}', [OrderController::class, 'detail'])->name('admin.detail');
    Route::get('order/delivery/{id}', [OrderController::class, 'delivery'])->name('admin.delivery');

    // Quản lý lịch hẹn
    Route::get('book', [BookingController::class, 'index'])->name('admin.book');
    Route::get('book/detail/{id}', [BookingController::class, 'detail'])->name('admin.bookDetail');
    Route::get('book/update/{id}', [BookingController::class, 'confirmBook'])->name('admin.bookConfirm');
    Route::get('book/cancel/{id}', [BookingController::class, 'UnConfirmBook'])->name('admin.bookUnConfirm');
    Route::get('book/complete/{id}', [BookingController::class, 'completeBooking'])->name('admin.bookComplete');
    Route::get('book/invoice/{id}', [BookingController::class, 'InvoiceBooking'])->name('admin.bookInvoice');

    // Quản lý khuyến mại
    Route::get('discount', [DiscountController::class, 'index'])->name('admin.discount');
    Route::get('discount/create', [DiscountController::class, 'create'])->name('admin.createDiscount');
    Route::get('discount/change/{id}/{name}', [DiscountController::class, 'edit'])->name('admin.changeDiscount');

    // Quản lý voucher
    Route::get('voucher', [VoucherController::class, 'index'])->name('admin.voucher');
    Route::get('voucher/create', [VoucherController::class, 'create'])->name('admin.createVoucher');
    Route::get('voucher/change/{id}/{name}', [VoucherController::class, 'edit'])->name('admin.changeVoucher');

    // Quản lý khách hàng
    Route::get('customer', [UserController::class, 'index'])->name('admin.customer');

    // Quản lý nhân viên
    Route::get('staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::get('staff/create', [StaffController::class, 'create'])->name('admin.staffCreate');
    Route::get('staff/edit/{id}/{name}', [StaffController::class, 'edit'])->name('admin.staffEdit');

    // Quản lý tài khoản
    Route::get('account', [UserController::class, 'index'])->name('admin.manageAccount');
    Route::get('account/{id}', [UserController::class, 'destroy'])->name('admin.destroy');

    /*
    |-------------------------------------------------
    | POST Routes
    |-------------------------------------------------
    */
    // Đăng nhập và đăng ký (nếu cần trong nhóm admin)
    // Route::post('login', [UserController::class, 'checkLogin'])->name('admin.checkLogin');
    // Route::post('register', [UserController::class, 'createAccountController'])->name('admin.register.active');
    // Route::post('register/sendOTP', [UserController::class, 'sendOTPCreateAccountController'])->name('admin.register.sendOTP');

    // Quản lý bài viết
    Route::post('post/createView', [PostController::class, 'create'])->name('admin.createPost');
    Route::post('post/ImageInContent/upload', [PostController::class, 'uploadImageInContent'])->name('admin.uploadImageInContent');
    Route::post('post/update', [PostController::class, 'update'])->name('admin.updatePost');

    // Quản lý sản phẩm
    Route::post('product/add', [ProductController::class, 'store'])->name('admin.createProduct');

    // Quản lý danh mục
    Route::post('category/add', [CategoryController::class, 'store'])->name('admin.createCat');

    // Quản lý dịch vụ
    Route::post('service/add', [ServiceController::class, 'store'])->name('admin.AddService');
    Route::post('service/change/{id}', [ServiceController::class, 'update'])->name('admin.updateService');
    Route::post('services/child/add/{id}', [ServiceController::class, 'addChildServiceController'])->name('admin.addChildService');
    Route::post('services/child/update', [ServiceController::class, 'updateChildServiceController'])->name('admin.updateChildService');

    // Quản lý đơn hàng
    Route::post('order/detail/ExportinvoiceView', [OrderController::class, 'InvoiceView'])->name('admin.invoiceView');
    Route::post('order/detail/Exportinvoice', [OrderController::class, 'ExportInvoice'])->name('admin.exportInvoices');

    // Quản lý lịch hẹn
    Route::post('book/complete', [BookingController::class, 'completeBookingPost'])->name('admin.bookCompletePost');

    // Quản lý nhân viên và lịch làm việc
    Route::post('staff/schedule/create', [ScheduleController::class, 'createSchedule'])->name('admin.createScheduleStaff');
    Route::post('staff/schedule/confirm', [ScheduleController::class, 'ConfirmSchedule'])->name('admin.confirmSchedule');
    Route::post('staff/schedule/update', [ScheduleController::class, 'updateSchedule'])->name('admin.updateSchedule');
    Route::post('staff/store', [StaffController::class, 'store'])->name('admin.staffStore');

    // Quản lý tài khoản
    Route::post('changePass', [UserController::class, 'changePass'])->name('admin.changePass');
    Route::post('updateProfile', [UserController::class, 'updateProfile'])->name('admin.updateProfile');

    // Quản lý khuyến mại
    Route::post('discount/create', [DiscountController::class, 'store'])->name('admin.storeDiscount');

    // Quản lý voucher
    Route::post('voucher/store', [VoucherController::class, 'store'])->name('admin.storeVoucher');

    /*
    |-------------------------------------------------
    | PUT/PATCH Routes
    |-------------------------------------------------
    */
    // Quản lý sản phẩm
    Route::put('product/change/{id}/{name}', [ProductController::class, 'update'])->name('admin.updateProduct');

    // Quản lý danh mục
    Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('admin.updateCat');

    // Quản lý nhân viên
    Route::put('staff/edit/{id}/{name}', [StaffController::class, 'update'])->name('admin.staffUpdate');

    // Quản lý khuyến mại
    Route::patch('discount/change/{id}/{name}', [DiscountController::class, 'update'])->name('admin.updateDiscount');

    // Quản lý voucher
    Route::patch('voucher/change/{id}/{name}', [VoucherController::class, 'update'])->name('admin.updateVoucher');

    /*
    |-------------------------------------------------
    | DELETE Routes
    |-------------------------------------------------
    */
    // Quản lý bài viết
    Route::delete('post/delete', [PostController::class, 'Delete'])->name('admin.deletePost');

    // Quản lý sản phẩm
    Route::delete('product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.deleteProduct');

    // Quản lý danh mục
    Route::delete('category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.deleteCat');

    // Quản lý dịch vụ
    Route::delete('service/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.deleteService');
    Route::delete('services/child/delete/{id}', [ServiceController::class, 'deleteChildServiceController'])->name('admin.deleteChildService');

    // Quản lý đơn hàng
    Route::delete('order/delete/{id}', [OrderController::class, 'destroy'])->name('admin.deleteOrder');

    // Quản lý khuyến mại
    Route::delete('discount/delete/{id}', [DiscountController::class, 'destroy'])->name('admin.destroyDiscount');

    // Quản lý voucher
    Route::delete('voucher/delete/{id}', [VoucherController::class, 'destroy'])->name('admin.destroyVoucher');

    // Quản lý lịch làm việc
    Route::delete('staff/schedule/delete', [ScheduleController::class, 'deleteSchedule'])->name('admin.deleteSchedule');
});
