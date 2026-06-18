<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['type', 'channel', 'recipient', 'subject', 'body', 'status', 'sent_at', 'metadata'];

    protected $casts = [
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];
}
