<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng đã đăng nhập với guard 'admin'
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Nếu không, chuyển hướng đến trang đăng nhập admin
        return redirect('/admin/login');
    }
}
