<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_name', 'action', 'table_name', 'details',
        'ip_address', 'user_agent', 'subsystem_slug'
    ];

    protected static function booted()
    {
        static::deleting(function ($log) {
            return false; // Prevent deletion - immutable logs
        });

        static::updating(function ($log) {
            return false; // Prevent updates - immutable logs
        });
    }
}
