<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Http\Request;

class CourseUserController extends Controller
{

    private $course;
    private $courseUser;
    private $courseDetail;

    public function __construct(Course $course, CourseUser $courseUser, CourseDetail $courseDetail)
    {
        $this->course = $course;
        $this->courseUser = $courseUser;
        $this->courseDetail = $courseDetail;
    }

    public function index()
    {
        $userSubscription = User::all();
        return view('user_data.index', compact('userSubscription'));
    }

    public function showParticipans($slug)
    {
        $slugId = $this->course->where('slug_course', $slug)->first();
        $courseParticipans = $this->courseUser->with(['course.payment_gateway' => function ($query) {
            $query->where('payment_status', 'success');
        }, 'user'])->where('course_id', $slugId->id)->where('status_course', 'unlock')->get();
        return view('course_online.participans', compact('courseParticipans', 'slugId'));
    }
}
