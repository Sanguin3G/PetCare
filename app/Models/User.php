<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Events\ForgetPassword;
use App\Events\RegistAccount;
use App\Jobs\DeleteOldOTPJob;
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
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function checkLoginModel($request): string
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return 'Not Found';
            }
            $pass1 = $user->password;
            Log::info($user);
            if (Hash::check($request->password, $pass1)) {
                $token = $user->createToken($user->email)->accessToken;
                return $token;
            }
            return 'Invalid';
        } catch (Throwable $e) {
            Log::error($e);
            return 'Error';
        }
    }
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function sendOTPCreateAccountModel($request): string
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return 'Account has existed';
            }
            $OTP = mt_rand(100000, 999999);
            event(new RegistAccount($request->email, $OTP));
            return 'success';
        } catch (Throwable $e) {
            Log::error($e);
            return 'error';
        }
    }
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function sendOTPForgetPasswordAccountModel($email): string
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return 'Email not exist';
            }
            $OTP = mt_rand(100000, 999999);
            event(new ForgetPassword($email, $OTP));
            return 'success';
        } catch (Throwable $e) {
            Log::error($e);
            return 'error';
        }
    }

    // Active account
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function createAccountModel($request): string
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
            if (!$otp_fetch) {
                return 'OTP not found';
            }
            $expired_time = $otp_fetch->expired_at;
            $expiredTime = new DateTime($expired_time);
            $now = new DateTime();
            if ($now > $expiredTime) {
                return 'OTP code is expired';
            }
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
                DB::table('opt_regist_forget_account')
                    ->where([
                        'email' => $request->email,
                        'OTP' => $request->OTP
                    ])->delete();
                DB::commit();
            }
            return 'Active account successful';
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'Error';
        }
    }

    // change password
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function updatePassword($request): string
    {
        try {
            DB::beginTransaction();
            $email =  Auth::guard('api')->user()->email;
            $user = User::where('email', $email)->first();
            if (!$user) {
                return "Account Not Found";
            }
            $oldPass = $user->password;
            Log::error($oldPass);
            if (!Hash::check($request->new_password, $oldPass)) {
                return "Password not valid";
            }
            if (Hash::check($request->new_password, $oldPass)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                DB::commit();
            }
            return "Success";
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return "Error";
        }
    }
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function updateInforAdminModel($request): string
    {
        try {
            DB::beginTransaction();
            $id = Auth::guard('api')->user()->id;
            $user = User::find($id);
            if (!$user) {
                return "Account Not Found";
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            DB::commit();
            return "Success";
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return "Error";
        }
    }
    /**
     * @param $request
     * @return string|object
     * 
     *  */
    public function getProfileModel($request): string|object
    {
        try {
            $user = $request->user();
            if (!$user) {
                return 'User Not Found';
            }
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
            }
            return (object)$data;
        } catch (Throwable $e) {
            Log::error($e);
            return 'error';
        }
    }
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function LogoutModel($request): string
    {
        try {
            if (!$request->user()) {
                return 'error';
            }
            $request->user()->token()->revoke(); // Thu hồi token
            return 'success';
        } catch (Throwable $e) {
            Log::error($e);
            return 'false';
        }
    }
    /**
     * Get detail user by id
     * 
     * @param int $idUser
     * @return \App\Models\User|null
     */
    public function getDetailUser(int $idUser): ?User
    {
        try {
            $user = User::where('id', $idUser)->select('id', 'name', 'email', 'phone', 'image')->first();
            return $user;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * @param $request
     * @return string
     * 
     *  */
    public function ResetPasswordAccountModel($request): string
    {
        try {
            $OTP = $request->OTP;
            $email = $request->email;
            $newpass = $request->password;
            Log::info($newpass);
            if ($this->checkOTP($OTP, $email)) {
                $this->resetPass($email, $newpass);
                return 'success';
            }
            return 'OTP not valid';
        } catch (Throwable $e) {
            Log::error("Error in ResetPasswordAccountModel " . $e->getMessage());
            return 'error';
        }
    }
    /**
     * @param string $email
     * @param string $newpass
     * @return bool
     * 
     *  */
    protected function resetPass(string $email, string $newpass): bool
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $email)->first();
            if (!$user) {
                return false;
            }
            $user->password = Hash::make($newpass);
            $user->save();
            dispatch(new DeleteOldOTPJob($email));
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    /**
     * @param string $OTP
     * @param string $email
     * @return bool
     * 
     *  */
    protected function checkOTP($OTP, $email): bool
    {
        try {
            $check = DB::table("opt_regist_forget_account")->where(['email' => $email, 'OTP' => $OTP])->orderBy('id', 'desc')->first();
            if ($check) {
                return true;
            }
            return false;
        } catch (Throwable $e) {
            Log::error($e);
            return false;
        }
    }
}
