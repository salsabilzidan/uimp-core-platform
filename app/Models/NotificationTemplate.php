<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = ['key', 'subject_ar', 'subject_en', 'body_ar', 'body_en', 'channels'];

    protected function casts(): array
    {
        return [
            'channels' => 'array',
        ];
    }
}