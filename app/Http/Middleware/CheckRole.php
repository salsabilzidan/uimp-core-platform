<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role  // المعامل الذي سيمرر من الـ Route
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // التأكد من أن المستخدم مسجل دخول ولديه الدور المطلوب
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // في حال لم يملك الصلاحية، نوقف الطلب ونرجع خطأ 403
            abort(403, 'عذراً، ليس لديك صلاحية الوصول لهذه الصفحة.');
        }

        return $next($request);
    }
}