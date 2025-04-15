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
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
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
            $result = $this->user->LogoutModel($request);
            if ($result === 'success') {
                return ApiResponse::Success(null, 'Thành công', 'success', 200);
            }
            return  ApiResponse::Success(null, 'Token không hợp lệ', 'error', 200);
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
            $result = $this->user->updatePassword($request);
            if ($result == 'Success') {
                return ApiResponse::Success(null, 'Update password successfully', 'success', 200);
            }
            if ($result == 'Password not valid') {
                return ApiResponse::Error(null, 'Old password is not correct', 'error', 400);
            }
            if ($result == 'Account Not Found') {
                return ApiResponse::Error(null, 'Account Not Found', 'error', 400);
            }
            return ApiResponse::Error(null, 'Some wrong occur', 'error', 400);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Some wrong occur', 'error', 400);
        }
    }
    public function sendOTPForgetPassController(Request $request)
    {
        try {
            $result = $this->user->sendOTPForgetPasswordAccountModel($request->email);
            if ($result === 'success') {
                return ApiResponse::Success(null, 'Success', 'success', 200);
            }
            if ($result === 'Email not exist') {
                return ApiResponse::Success(null, 'Email is not exist in system', 'error', 200);
            }
            return ApiResponse::Error(null, 'Error', 'error', 400);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', 500);
        }
    }
    public function resetPasswordController(Request $request)
    {
        try {
            $result = $this->user->ResetPasswordAccountModel(($request));
            if ($result === 'success') {
                return ApiResponse::Success(null, 'Reset password successfully', 'success', 200);
            }
            if ($result === 'OTP not valid') {
                return ApiResponse::Success(null, $result, 'error', 200);
            }
            return ApiResponse::Error(null, 'Some wrong occur', 'error', 400);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Some wrong occur', 'error', 400);
        }
    }
}
