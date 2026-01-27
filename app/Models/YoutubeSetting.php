<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeSetting extends Model
{
    protected $fillable = [
        'video_id',
        'live_chat_id',
        'keywords',
        'sheet_id',
        'page_token',
        'is_active'
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean'
    ];
}
