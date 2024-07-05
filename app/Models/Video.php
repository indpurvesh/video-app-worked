<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 
        'user_id',
        "description",
        "player",
        "thumbnail",
        "status",
        "api_video_id",
        "is_featured",
        "api_video_source"
    ];
}
