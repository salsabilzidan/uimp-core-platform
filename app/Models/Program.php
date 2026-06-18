<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'code', 'faculty_id', 'duration_years', 'description'];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(College::class, 'faculty_id');
    }

    public function studentPrograms(): HasMany
    {
        return $this->hasMany(StudentProgram::class);
    }
}