<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['user_id', 'department_id', 'employee_code', 'phone', 'academic_rank_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function academicRank(): BelongsTo
    {
        return $this->belongsTo(AcademicRank::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(EmployeeHistory::class);
    }
}
