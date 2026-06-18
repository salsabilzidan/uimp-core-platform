<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicRank extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'level'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}