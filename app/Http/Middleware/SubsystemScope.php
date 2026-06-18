<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubsystemScope
{
    public function handle(Request $request, Closure $next, string ...$scopes): Response
    {
        $subsystem = $request->get('authenticated_subsystem');

        if (!$subsystem) {
            return response()->json(['error' => 'النظام الفرعي غير موثّق'], 401);
        }

        $permissions = $subsystem->permissions ?? [];

        if (empty($scopes)) {
            return $next($request);
        }

        foreach ($scopes as $scope) {
            if (in_array($scope, $permissions)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'النظام الفرعي لا يملك الصلاحية للوصول إلى هذا المورد'], 403);
    }
}
