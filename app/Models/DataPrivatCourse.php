<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPrivatCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'major', 'institusi', 'description_private_course', 'teaching_private_course', 'description_teaching_private_course', 'deal_price_private_course', 'salary_teaching', 'net_funds_course'
    ];
}
