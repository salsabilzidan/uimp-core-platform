<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeHistory extends Model
{
    protected $fillable = ['employee_id', 'department_id', 'academic_rank_id', 'position_ar', 'position_en', 'start_date', 'end_date', 'notes'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function academicRank(): BelongsTo
    {
        return $this->belongsTo(AcademicRank::class);
    }
}