<?php

namespace App\Http\Middleware;

use App\Models\Subsystem;
use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubsystemAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');

        if (!$apiKey) {
            return response()->json(['error' => 'مفتاح API مطلوب في الترويسة X-API-Key'], 401);
        }

        $subsystem = Subsystem::where('api_key', $apiKey)
            ->where('is_active', true)
            ->first();

        if (!$subsystem) {
            AuditLog::create([
                'user_name' => 'System',
                'action' => 'API_KEY_REJECTED',
                'table_name' => 'subsystems',
                'details' => 'Invalid API key attempt from IP: ' . $request->ip(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json(['error' => 'مفتاح API غير صالح'], 403);
        }

        $request->merge(['authenticated_subsystem' => $subsystem]);

        return $next($request);
    }
}
