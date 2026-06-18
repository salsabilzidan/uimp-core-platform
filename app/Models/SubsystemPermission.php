<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubsystemPermission extends Model
{
    protected $fillable = ['subsystem_id', 'permission', 'description'];

    public function subsystem(): BelongsTo
    {
        return $this->belongsTo(Subsystem::class);
    }
}