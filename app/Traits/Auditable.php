<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::logAudit($model, 'CREATED', $model->toArray());
        });

        static::updated(function ($model) {
            self::logAudit($model, 'UPDATED', $model->getChanges());
        });

        static::deleted(function ($model) {
            self::logAudit($model, 'DELETED', ['id' => $model->id]);
        });
    }

    private static function logAudit($model, string $action, $details): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        AuditLog::create([
            'user_name' => Auth::check() ? Auth::user()->name : 'System',
            'action'    => $action,
            'table_name' => $model->getTable(),
            'details'   => $details ? json_encode($details) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}