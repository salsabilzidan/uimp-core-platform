<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use Auditable;

    protected $fillable = ['campus_id', 'code', 'name_ar', 'name_en', 'location', 'floors', 'description'];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
