<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Events\RegistAccount;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;
use DateTime;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    public $primaryKey = 'id';
    public $timestamp = true;
    public $incrementing = true;
    // public $keyType = 'string';
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($user) {
    //         do {
    //             $randomId = Str::upper(Str::random(15));
    //         } while (self::where('id', $randomId)->exists());
    //         $user->id = $randomId;
    //     });
    // }
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function checkLoginModel($request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return 'Not Found';
            }
            // $userCheck = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            $pass1 = $user->password;
            // Log::error($pass1);
            if (Hash::check($request->password, $pass1)) {
                // if ($userCheck) {
                // Log::error($user);
                $token = $user->createToken($user->email)->accessToken;
                // Auth::guard('web')->login($user);
                // Log::info("User logged in: " . $user->id . " | Session ID: " . Session::getId());
                return $token;
            } else {
                return 'Invalid';
            }
        } catch (Throwable $e) {
            Log::error($e);
            return 'Error';
        }
    }
    public function sendOTPCreateAccountModel($request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                // return response()->json($user);
                // đã tồn tại người dùng
                return 0;
            } else {
                $OTP = mt_rand(100000, 999999);
                event(new RegistAccount($request->email, $OTP));
                // dispatch(new SendOTPRegister($request->email, $OTP));
                return true;
            }
        } catch (Throwable $e) {
            Log::error($e);
            return false;
        }
    }
    // Active tài khoản
    public function createAccountModel($request)
    {
        try {
            DB::beginTransaction();
            $otp_fetch = DB::table('opt_regist_forget_account')
                ->where([
                    'OTP' => $request->OTP,
                    'email' => $request->email
                ])
                ->orderBy('id', 'DESC')
                ->first();
            if ($otp_fetch) {
                $expired_time = $otp_fetch->expired_at;
                $expiredTime = new DateTime($expired_time);
                $now = new DateTime();
                // kiểm tra xem OTP đã hết hạn hay chưa
                if ($now > $expiredTime) {
                    return 'OTP code is expired';
                } else {
                    $customer = User::where('email', $request->email)->first();
                    if (!$customer) {
                        $customer = new User();
                        $customer->name = $request->name;
                        $customer->email = $request->email;
                        $customer->password = Hash::make($request->password);
                        $customer->phone = $request->phone;
                        $customer->role = $request->role;
                        $customer->status = 'active';
                        $customer->save();
                        // xóa mã otp vừa tạo
                        $otp = DB::table('opt_regist_forget_account')
                            ->where([
                                'email' => $request->email,
                                'OTP' => $request->OTP
                            ])->delete();
                    }
                }
                DB::commit();
                return 'Active account successful';
            } else {
                return "OTP not found";
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'Error';
        }
    }
    // đổi mật khẩu
    public function updatePasswordAdminModel($request)
    {
        try {
            DB::beginTransaction();
            $id = Auth::guard('api')->user()->id;
            $email =  Auth::guard('api')->user()->email;
            $user = User::where('email', $email)->first();
            if ($user) {
                $oldPass = $user->password;
                Log::error($oldPass);
                if (Hash::check($request->new_password, $oldPass)) {
                    $user->password = Hash::make($request->new_password);
                    Log::error(1);
                    $user->save();
                    DB::commit();
                    return "Success";
                } else {
                    return "Password not valid";
                }
            } else {
                return "Account Not Found";
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return "Error";
        }
    }
    public function updateInforAdminModel($request)
    {
        try {
            DB::beginTransaction();
            $id = Auth::guard('api')->user()->id;
            $email = Auth::guard('api')->user()->email;
            $user = User::find($id);
            if ($user) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();
                DB::commit();
                return "Success";
            } else {
                return "Account Not Found";
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return "Error";
        }
    }
    public function getProfileModel($request)
    {
        try {
            $user = $request->user(); // Lấy user đã xác thực qua token
            if ($user) {
                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? null,
                    'role' => $user->role ?? null,
                    'status' => $user->status ?? null,
                    'image' => $user->image
                ];
                return (object)$data;
            } else {
                return 'User Not Found';
            }
        } catch (Throwable $e) {
            Log::error($e);
            return false;
        }
    }
    public function LogoutModel($request)
    {
        try {
            if ($request->user()) {
                $request->user()->token()->revoke(); // Thu hồi token
                return 'success';
            } else {
                return 'error';
            }
        } catch (Throwable $e) {
            Log::error($e);
            return false;
        }
    }
    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }
}
