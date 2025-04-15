<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::error('middleware');
        Log::info(Auth::user());
        if (Auth::user()) {
            if (Auth::user()->role === 'admin') {
                return $next($request);
            }
            return ApiResponse::Success(null, "You don't have authority", 'error', 200);
        }
        return ApiResponse::Error(null, "Unauthorize", 'error', 200);
    }
}
