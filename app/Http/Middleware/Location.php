<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Location
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập với quyền admin (hoặc quyền quản lý location)
        if (Auth::guard('admins')->check()) {
            return $next($request); // Tiếp tục xử lý yêu cầu
        } else {
            // Nếu không có quyền, chuyển hướng đến trang đăng nhập
            return redirect('/log-in');
        }
    }
}
