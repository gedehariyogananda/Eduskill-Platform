<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\CourseDetail;
use App\Models\CourseUser;
use Illuminate\Http\Request;

class CourseController extends Controller
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
        $allCourses = $this->course->with(['course_details', 'course_users' => function ($query) {
            $query->where('status_course', 'unlock');
        }])->where('status_course', '!=', 'archived')->get();

        return view('course_online.index', compact('allCourses'));
    }

    public function archive($slug)
    {
        $course = $this->course->where('slug_course', $slug)->first();

        $course->update([
            'status_course' => 'unpublished'
        ]);

        return redirect()->route('course.index')->with('success', 'Data Course Berhasil Diarsipkan');
    }

    public function unarchive($slug)
    {
        $course = $this->course->where('slug_course', $slug)->first();

        $course->update([
            'status_course' => 'published'
        ]);

        return redirect()->route('course.index')->with('success', 'Data Course Berhasil DiPublish');
    }

    public function archives($slug)
    {
        $course = $this->course->where('slug_course', $slug)->first();

        $course->update([
            'status_course' => 'archived'
        ]);

        return redirect()->route('course.index')->with('success', 'Data Course Berhasil Diarsipkan');
    }

    public function recovery($slug)
    {
        $course = $this->course->where('slug_course', $slug)->first();

        $course->update([
            'status_course' => 'unpublished'
        ]);

        return redirect()->route('course.indexArchived')->with('success', 'Data Course Berhasil Dipulihkan');
    }


    public function edit($slug)
    {
        $course = $this->course->where('slug_course', $slug)->first();
        return view('course_online.edit', compact('course'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name_course' => 'required',
            'instructor_course' => 'nullable',
            'experiences_instructor_course' => 'nullable',
            'description_course' => 'required',
            'category_course' => 'required',
            'price_course' => 'required_if:is_free_course,false',
            'price_discount_course' => 'required_if:is_free_course,false',
            'banner_course' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $course = $this->course->where('slug_course', $slug)->first();

        if ($request->is_free_course == null) {
            $initialFreeCourse = false;
        } else {
            $initialFreeCourse = $request->is_free_course;
        }

        if ($request->is_free_course == true) {
            $initialPrice = $request->price_course;
            $initialPriceDiscount = 0;
        }

        if ($request->is_free_course == false) {
            $initialPrice = $request->price_course;
            $initialPriceDiscount = $request->price_discount_course;
        }
        if ($request->hasFile('banner_course')) {
            $file = $request->file('banner_course');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/banner-course', $fileName);
            $pathDatabaseInit = 'banner-course/' . $fileName;
        } else {
            $pathDatabaseInit = $course->banner_course;
        }

        $successUpdate = $course->update([
            'name_course' => $request->name_course,
            'instructor_course' => $request->instructor_course ? $request->instructor_course : "Eduskill Teaching",
            'experiences_instructor_course' => $request->experiences_instructor_course ? $request->experiences_instructor_course : "-",
            'banner_course' => $pathDatabaseInit,
            'description_course' => $request->description_course,
            'category_course' => $request->category_course,
            'price_course' => $initialPrice,
            'price_discount_course' => $initialPriceDiscount,
            'is_free_course' => $initialFreeCourse,
        ]);

        if (!$successUpdate) {
            return redirect()->route('course.edit', $slug)->with('error', 'Data Course Gagal Diubah');
        }

        return redirect()->route('course.index')->with('success', 'Data Course Berhasil Diubah');
    }

    public function create()
    {
        return view('course_online.edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_course' => 'required',
            'instructor_course' => 'nullable',
            'experiences_instructor_course' => 'nullable',
            'description_course' => 'required',
            'category_course' => 'required',
            'price_course' => 'required_if:is_free_course,false',
            'banner_course' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->is_free_course == null) {
            $initialFreeCourse = false;
        } else {
            $initialFreeCourse = $request->is_free_course;
        }

        if ($request->is_free_course == true) {
            $initialPrice = $request->price_course;
            $initialPriceDiscount = 0;
        }

        if ($request->is_free_course == false) {
            $initialPrice = $request->price_course;
            $initialPriceDiscount = $request->price_discount_course;
        }
        if ($request->hasFile('banner_course')) {
            $file = $request->file('banner_course');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/banner-course', $fileName);
            $pathDatabaseInit = 'banner-course/' . $fileName;
        }

        $successInsert = $this->course->create([
            'name_course' => $request->name_course,
            'instructor_course' => $request->instructor_course ? $request->instructor_course : "Eduskill Teaching",
            'experiences_instructor_course' => $request->experiences_instructor_course ? $request->experiences_instructor_course : "-",
            'slug_course' => Str::slug($request->name_course . '-course-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 10)),
            'banner_course' => $pathDatabaseInit,
            'description_course' => $request->description_course,
            'category_course' => $request->category_course,
            'price_course' => $initialPrice,
            'price_discount_course' => $initialPriceDiscount,
            'is_free_course' => $initialFreeCourse,
        ]);

        if (!$successInsert) {
            return redirect()->route('course.create')->with('error', 'Data Course Gagal Ditambahkan');
        }

        return redirect()->route('course.index')->with('success', 'Data Course Berhasil Ditambahkan');
    }


    // --------------------------- ARCHIVED -------------------------------------- \\
    public function indexArchived()
    {
        $allCourses = $this->course->with(['course_details', 'course_users' => function ($query) {
            $query->where('status_course', 'unlock');
        }])->where('status_course', 'archived')->get();

        return view('course_online.index', compact('allCourses'));
    }
}
