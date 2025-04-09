<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // dd(session()->id());
            // Kiểm tra đăng nhập với guard 'api'
            $user = Auth::guard('api')->user(); // Lấy user trực tiếp từ guard 'api'
            // dd($user);
            if ($user) {
                Log::error("User Found: " . $user->id);
                // Kiểm tra role
                if ($user->role == 'admin' || $user->role == 'staff') {
                    return $next($request);
                } else {
                    Log::error("Invalid Role");
                    return redirect(route('admin.login'));
                }
            } else {
                Log::error("Not Login - User Null");
                return redirect(route('admin.login'));
            }
        } catch (\Exception $e) {
            Log::error("Middleware Error: " . $e->getMessage());
            return redirect(route('admin.login'));
        }
    }
}
