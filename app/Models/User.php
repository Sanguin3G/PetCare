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
            $pass1 = $user->password;
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
    public function sendOTPCreateAccountModel($request)
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
            if (!$otp_fetch) {
                return "OTP not found";
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
                return 'Active account successful';
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'Error';
        }
    }
    // change password
    public function updatePassword($request)
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
                Log::error(1);
                $user->save();
                DB::commit();
                return "Success";
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
    public function getProfileModel($request)
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
                return (object)$data;
            }
        } catch (Throwable $e) {
            Log::error($e);
            return false;
        }
    }
    public function LogoutModel($request)
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
    public function getDetailUser(int $idUser)
    {
        try {
            $user = User::where('id', $idUser)->select('id', 'name', 'email', 'phone', 'image')->first();
            return $user;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
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
