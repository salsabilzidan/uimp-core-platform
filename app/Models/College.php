<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class College extends Model
{
    use Auditable;

    protected $table = 'faculties';

    protected $fillable = ['code', 'name_ar', 'name_en'];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'faculty_id');
    }
}
