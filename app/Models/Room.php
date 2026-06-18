<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use Auditable;

    protected $fillable = ['building_id', 'code', 'name_ar', 'name_en', 'floor', 'capacity', 'type', 'is_lab', 'description'];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
