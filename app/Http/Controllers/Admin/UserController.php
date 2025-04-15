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
use Illuminate\Http\JsonResponse;

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
    protected $User;
    public function __construct(User $user)
    {
        $this->User = $user;
    }
    public function index()
    {
        $user = User::paginate(10);
        return view('Admin.AccountView', ['user' => $user]);
    }
    public function profile()
    {
        return view('Admin.ProfileView');
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function checkLogin(Request $request): JsonResponse
    {
        try {
            $result = $this->User->checkLoginModel($request);
            if ($result == 'Invalid') {
                return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
            }
            if ($result == 'Error') {
                return ApiResponse::Error(null, self::MSG_ERROR, 'error', 400);
            }
            if ($result == 'Not Found') {
                return ApiResponse::Error(null, 'Email không tồn tại !', 'error', 200);
            }
            return ApiResponse::Success($result, self::MSG_SUCCESS, 'success', 200);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }

    /**
     * send OTP code
     * @param Request $request
     * @return ApiResponse
     */
    public function sendOTPCreateAccountController(Request $request): JsonResponse
    {
        try {
            $result = $this->User->sendOTPCreateAccountModel($request);
            if ($result == 'Account has existed') {
                return ApiResponse::Error(null, self::MSG_EMAIL_EXIST, 'error', 400);
            }
            if ($result == 'success') {
                return ApiResponse::Success(null, self::MSG_SEND_OTP, 'success', 200);
            }
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }
    /**
     * active account
     *
     * @param Request $request
     * @return ApiResponse
     */
    public function createAccountController(Request $request): JsonResponse
    {
        try {
            $result = $this->User->createAccountModel($request);
            if ($result === 'Active account successful') {
                return ApiResponse::Success(null, self::MSG_CREATE_ACCOUNT_SUCCESS, 'success', 200);
            }
            if ($result === 'OTP code is expired') {
                return ApiResponse::Error(null, self::MSG_OTP_EXPIRED, 'error', 400);
            }
            if ($result === 'OTP not found') {
                return ApiResponse::Error(null, self::MSG_ERROR_OTP, 'error', 400);
            }
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }

    /**
     * 
     * @param Request $request
     * @return ApiResponse
     */
    public function changePass(Request $request): JsonResponse
    {
        try {
            $result = $this->User->updatePassword($request);
            if ($result == 'Success') {
                return ApiResponse::Success(null, self::MSGG_CHANGE_PASSWORD_SUCCESS, 'success', 200);
            }
            if ($result == 'Password not valid') {
                return ApiResponse::Error(null, self::MSG_ERROR_PASS, 'error', 400);
            }
            if ($result == 'Account Not Found') {
                return ApiResponse::Error(null, self::MSG_ACCOUNT_NOT_EXIST, 'error', 400);
            }
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }

    /**
     * 
     * @param Request $request
     * @return ApiResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {

        try {
            $result = $this->User->updateInforAdminModel($request);
            if ($result == 'Success') {
                return ApiResponse::Success(null, self::MSG_UPDATE_SUCCESS, 'success', 200);
            }
            if ($result == 'Account Not Found') {
                return ApiResponse::Error(null, self::MSG_ACCOUNT_NOT_EXIST, 'success', 400);
            }
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 400);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, self::MSG_ERROR_ACCOUNT, 'error', 500);
        }
    }

    /**
     * 
     * @param Request $request
     * @return ApiResponse
     */
    public function getUserProfile(Request $request): JsonResponse
    {
        try {
            $result = $this->User->getProfileModel($request);
            if ($result == 'error') {
                return ApiResponse::Error(NULL, self::MSG_ERROR, 'error', 500);
            }
            if ($result == 'User Not Found') {
                return ApiResponse::Error(null, self::MSG_ACCOUNT_NOT_EXIST, 'error', 200);
            }
            return ApiResponse::Success($result, self::MSG_SUCCESS, 'error', 200);
        } catch (Throwable $e) {
            return ApiResponse::Error(NULL, self::MSG_ERROR, 'error', 500);
        }
    }

    /**
     *
     * @param Request $request
     * @return ApiResponse
     */
    public function Logout(Request $request): JsonResponse
    {
        try {
            $result = $this->User->LogoutModel($request);
            if ($result == 'success') {
                return ApiResponse::Success($result, 'Đăng xuất thành công', 'success', 200);
            }
            if ($result == 'error') {
                return ApiResponse::Success($result, self::MSG_ACCOUNT_NOT_EXIST, 'error', 200);
            }
            return ApiResponse::Error($result, self::MSG_ERROR, 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, self::MSG_ERROR, 'error', 500);
        }
    }
}
