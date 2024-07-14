<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title_course',
        'url_video_course',
        'duration_course',
        'transkrip_course',
        'slug_course'
    ];
}
