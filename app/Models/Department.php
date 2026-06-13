<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    protected $table = 'departments';//
    public function faculty(): BelongsTo
{
    // ربط القسم بالكلية عبر الحقل المشترك faculty_id
    return $this->belongsTo(College::class, 'faculty_id');
}

}
