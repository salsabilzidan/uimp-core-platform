<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public static function log(string $action, string $tableName, $details = null, ?string $subsystemSlug = null): AuditLog
    {
        $user = Auth::user();
        $request = request();

        return AuditLog::create([
            'user_name'      => $user ? $user->name : 'System',
            'action'         => $action,
            'table_name'     => $tableName,
            'details'        => $details ? json_encode($details) : null,
            'ip_address'     => $request?->ip(),
            'user_agent'     => $request?->userAgent(),
            'subsystem_slug' => $subsystemSlug,
        ]);
    }
}
