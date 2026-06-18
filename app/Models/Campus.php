<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campus extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'location'];

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }
}