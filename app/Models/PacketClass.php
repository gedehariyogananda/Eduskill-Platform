<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course_user()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
