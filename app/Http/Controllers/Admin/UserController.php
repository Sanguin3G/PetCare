<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Http\Responses\ApiResponse;

class UserController extends Controller
{
    public const MSG_ERROR = "Có lỗi xảy ra !";
    public const MSG_ERROR_ACCOUNT = "Tài khoản hoặc mật khẩu không chính xác !";
    public const MSG_ERROR_PASS = "Mật khẩu không chính xác !";
    public const MSG_EMAIL_EXIST = "Email đã tồn tại";
    public const MSG_SEND_OTP = "Đã gửi mã OTP";
    public const MSG_ERROR_OTP = "OTP không hợp lệ";
    public const MSG_OTP_EXPIRED = "OTP đã hết hiệu lực";
    public const MSG_ACCOUNT_NOT_EXIST = "Tài khoản không tồn tại";
    public const MSG_UPDATE_SUCCESS = "Cập nhật thông tin thành công !";
    public const MSG_DELETE_SUCCESS = "Xóa tài khoản thành công !";
    public const MSG_CREATE_ACCOUNT_SUCCESS = "Tạo tài khoản thành công !";
    public const MSGG_CHANGE_PASSWORD_SUCCESS = "Đổi mật khẩu thành công !";
    public const MSG_SUCCESS = "Thành công";
    public function index()
    {
        $user = User::paginate(10);
        return view('Admin.AccountView', ['user' => $user]);
    }
    public function profile()
    {
        return view('Admin.ProfileView');
    }
    // public function logOut()
    // {
    //     Auth::logout();
    //     return redirect(route('admin.login'));
    // }
    public function checkLogin(Request $request)
    {
        try {
            $user = new User();
            $result = $user->checkLoginModel($request);
            if ($result == 'Invalid') {
                return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
            } elseif ($result == 'Error') {
                return ApiResponse::Error(null, self::MSG_ERROR, 'error', 400);
            } elseif ($result == 'Not Found') {
                return ApiResponse::Error(null, 'Email không tồn tại !', 'error', 200);
            } else {
                // return response()->json($result);
                return ApiResponse::Success($result, self::MSG_SUCCESS, 'success', 200);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }
    // send OTP code
    public function sendOTPCreateAccountController(Request $request)
    {
        try {
            $model = new User();
            $result = $model->sendOTPCreateAccountModel($request);
            if ($result == 0) {
                return ApiResponse::Error(null, self::MSG_EMAIL_EXIST, 'error', 400);
            } elseif ($result == true) {
                return ApiResponse::Success(null, self::MSG_SEND_OTP, 'success', 200);
            } else {
                return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }
    // active account
    public function createAccountController(Request $request)
    {
        // return response()->json($request);
        try {
            $user = new User();
            $result = $user->createAccountModel($request);
            if ($result === 'Active account successful') {
                return ApiResponse::Success(null, self::MSG_CREATE_ACCOUNT_SUCCESS, 'success', 200);
            } elseif ($result === 'OTP code is expired') {
                return ApiResponse::Error(null, self::MSG_OTP_EXPIRED, 'error', 400);
            } elseif ($result === 'OTP not found') {
                return ApiResponse::Error(null, self::MSG_ERROR_OTP, 'error', 400);
            } else {
                return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }
    public function changePass(Request $request)
    {
        try {
            $user = new User();
            $result = $user->updatePasswordAdminModel($request);
            if ($result == 'Success') {
                return ApiResponse::Success(null, self::MSGG_CHANGE_PASSWORD_SUCCESS, 'success', 200);
            } elseif ($result == 'Password not valid') {
                return ApiResponse::Error(null, self::MSG_ERROR_PASS, 'error', 400);
            } elseif ($result == 'Account Not Found') {
                return ApiResponse::Error(null, self::MSG_ACCOUNT_NOT_EXIST, 'error', 400);
            } else {
                return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }
    public function updateProfile(Request $request)
    {

        try {
            $user = new User();
            $result = $user->updateInforAdminModel($request);
            if ($result == 'Success') {
                return ApiResponse::Success(null, self::MSG_UPDATE_SUCCESS, 'success', 200);
            } elseif ($result == 'Account Not Found') {
                return ApiResponse::Error(null, self::MSG_ACCOUNT_NOT_EXIST, 'success', 400);
            } else {
                return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }
    public function getUserProfile(Request $request)
    {
        try {
            $user = new User();
            $result = $user->getProfileModel($request);
            if ($result == false) {
                return ApiResponse::Error(NULL, self::MSG_ERROR, 'error', 500);
            } elseif ($result == 'User Not Found') {
                return ApiResponse::Error(null, self::MSG_ACCOUNT_NOT_EXIST, 'error', 200);
            } else {
                return ApiResponse::Success($result, self::MSG_SUCCESS, 'error', 200);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(NULL, self::MSG_ERROR, 'error', 500);
        }
    }
    public function Logout(Request $request)
    {
        try {
            $user = new User();
            $result = $user->LogoutModel($request);
            if ($result == 'success') {
                return ApiResponse::Success($result, 'Đăng xuất thành công', 'success', 200);
            } elseif ($result == 'error') {
                return ApiResponse::Success($result, self::MSG_ACCOUNT_NOT_EXIST, 'error', 200);
            } else {
                return ApiResponse::Error($result, self::MSG_ERROR, 'error', 500);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, self::MSG_ERROR, 'error', 500);
        }
    }
    public function destroy(string $id)
    {
        $user = User::find($id);
        try {
            $user->delete();
        } catch (Throwable) {
            return redirect(route('admin.manageAccount'))->with('error', 'Xóa tài khoản thất bại');
        }
        return redirect(route('admin.manageAccount'))->with('notice', 'Xóa tài khoản thành công');
    }
}
