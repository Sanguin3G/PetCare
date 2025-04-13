<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function GetChangePassView()
    {
        $user = Auth::user();
        return view('User.ChangePassView', ['user' => $user]);
    }
    public function changePass(Request $request)
    {
        try {
            $user = new User();
            $result = $user->updatePassword($request);
            if ($result == 'Success') {
                return ApiResponse::Success(null, 'Update password successfully', 'success', 200);
            } elseif ($result == 'Password not valid') {
                return ApiResponse::Error(null, 'Old password is not correct', 'error', 400);
            } elseif ($result == 'Account Not Found') {
                return ApiResponse::Error(null, 'Account Not Found', 'error', 400);
            } else {
                return ApiResponse::Error(null, 'Some wrong occur', 'error', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Some wrong occur', 'error', 400);
        }
    }
}
