<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseDetailController extends Controller
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

    public function show($slug)
    {
        $courseDetails = $this->course->with('course_details', 'course_users', 'payment_gateway')->where('slug_course', $slug)->first();
        return view('course_online.show', compact('courseDetails', 'slug'));
    }


    public function addCourses($slug)
    {
        $course = $this->course->where('slug_course', $slug)->first();
        $routeCourse = $course->slug_course;
        return view('course_online.add_courses', compact('course', 'routeCourse'));
    }

    public function storeCourses(Request $request, $slug)
    {
        $request->validate([
            'title_course' => 'required',
            'url_video_course' => 'required',
            'duration_course' => 'required',
            'transkrip_course' => 'required'
        ]);

        $course = $this->course->where('slug_course', $slug)->first();

        $successInsert = $this->courseDetail->create([
            'course_id' => $course->id,
            'title_course' => $request->title_course,
            'url_video_course' => $request->url_video_course,
            'duration_course' => $request->duration_course,
            'transkrip_course' => $request->transkrip_course,
            'slug_course' =>  Str::slug($request->title_course . '-course-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 10))
        ]);

        if (!$successInsert) {
            return redirect()->route('course.addCourses', $slug)->with('error', 'Data Courses Gagal Ditambahkan');
        }

        return redirect()->route('course.show', $slug)->with('success', 'Data Courses Berhasil Ditambahkan');
    }

    public function editCourses($slug)
    {
        $course = $this->courseDetail->where('slug_course', $slug)->first();
        $init = $this->course->where('id', $course->course_id)->first();
        $routeCourse = $init->slug_course;
        return view('course_online.add_courses', compact('course', 'routeCourse'));
    }

    public function updateCourses(Request $request, $slug)
    {
        $request->validate([
            'title_course' => 'required',
            'url_video_course' => 'required',
            'duration_course' => 'required',
            'transkrip_course' => 'required'
        ]);

        $course = $this->courseDetail->where('slug_course', $slug)->first();
        $slugBack = $this->course->where('id', $course->course_id)->first();

        $successUpdate = $course->update([
            'title_course' => $request->title_course,
            'url_video_course' => $request->url_video_course,
            'duration_course' => $request->duration_course,
            'transkrip_course' => $request->transkrip_course,
            'slug_course' =>  Str::slug($request->title_course . '-course-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 10))
        ]);

        if (!$successUpdate) {
            return redirect()->route('course.editCourses', $slug)->with('error', 'Data Courses Gagal Diubah');
        }

        return redirect()->route('course.show', $slugBack->slug_course)->with('success', 'Data Courses Berhasil Diubah');
    }

    public function destroyCourses($slug)
    {
        $course = $this->courseDetail->where('slug_course', $slug)->first();
        $slugBack = $this->course->where('id', $course->course_id)->first();

        $successDelete = $course->delete();
        if (!$successDelete) {
            return redirect()->route('course.show', $slugBack->slug_course)->with('error', 'Data Courses Gagal Dihapus');
        }

        return redirect()->route('course.show', $slugBack->slug_course)->with('success', 'Data Courses Berhasil Dihapus');
    }
}
