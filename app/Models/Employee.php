<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    // تحديد الحقول المسموح بتعبئتها جمودياً لحمايتها
    protected $fillable = ['user_id', 'department_id', 'employee_code', 'phone'];

    // العلاقة مع جدول الحسابات الأساسي Users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // العلاقة مع جدول الأقسام العلمية
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}