<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminSessionController extends Controller
{
    public const COOKIE = 'petcare_admin_token';

    public function establish(Request $request)
    {
        $token = $request->bearerToken();
        $guard = Auth::guard('api');
        $guard->setRequest($request);
        $user = $token ? $guard->user() : null;

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403)
                ->withCookie(Cookie::forget(self::COOKIE, '/admin'));
        }

        return response()->json(['status' => 'success'])->withCookie(
            Cookie::make(self::COOKIE, $token, 720, '/admin', null, $request->isSecure(), true, false, 'strict')
        );
    }

    public function clear(Request $request)
    {
        return response()->json(['status' => 'success'])
            ->withCookie(Cookie::forget(self::COOKIE, '/admin'));
    }
}
