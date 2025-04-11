<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class CustomerController extends Controller
{
    public function Login()
    {
        return view('User.LoginView');
    }
    public function Register()
    {
        return view('User.RegisterView');
    }
    public function Logout(Request $request)
    {
        try {
            $model = new User();
            $result = $model->LogoutModel($request);
            if ($result === 'success') {
                return ApiResponse::Success(null, 'Thành công', 'success', 200);
            } else {
                return  ApiResponse::Success(null, 'Token không hợp lệ', 'error', 200);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
        }
    }
}
