<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\AdminSessionController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class RequireAdminSession
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie(AdminSessionController::COOKIE);
        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
            $guard = Auth::guard('api');
            $guard->setRequest($request);
            $user = $guard->user();
            if ($user && $user->role === 'admin') {
                $request->setUserResolver(fn () => $user);
                return $next($request);
            }
        }

        return redirect()->route('admin.login')
            ->withCookie(Cookie::forget(AdminSessionController::COOKIE, '/admin'));
    }
}
