<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subsystem extends Model
{
    use Auditable;

    protected $fillable = [
        'name', 'slug', 'description', 'api_key', 'api_key_generated_at',
        'contact_email', 'is_active', 'allowed_ips', 'permissions', 'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'api_key_generated_at' => 'datetime',
        'allowed_ips' => 'array',
        'permissions' => 'array',
        'metadata' => 'array',
    ];

    public function subsystemPermissions(): HasMany
    {
        return $this->hasMany(SubsystemPermission::class);
    }
}
