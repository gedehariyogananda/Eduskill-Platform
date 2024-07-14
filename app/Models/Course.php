<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_course',
        'instructor_course',
        'experiences_instructor_course',
        'slug_course',
        'banner_course',
        'description_course',
        'category_course',
        'price_course',
        'price_discount_course',
        'is_free_course',
        'status_course'
    ];

    public function course_details()
    {
        return $this->hasMany(CourseDetail::class);
    }

    public function course_users()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function payment_gateway()
    {
        return $this->hasOne(PaymentGateway::class);
    }

    public function packet_classes()
    {
        return $this->hasMany(PacketClass::class, 'id');
    }
}
