<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessedComment extends Model
{
    use HasFactory;
    protected $fillable = ['comment_id', 'video_id'];
}
