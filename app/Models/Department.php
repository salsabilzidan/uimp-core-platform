<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use Auditable;

    protected $fillable = ['faculty_id', 'code', 'name_ar', 'name_en'];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(College::class, 'faculty_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'department_id');
    }

    public function laboratories(): HasMany
    {
        return $this->hasMany(Laboratory::class, 'department_id');
    }
}
