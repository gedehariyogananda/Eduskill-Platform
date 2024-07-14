<?php

namespace App\Http\Controllers;

use App\Models\DataPrivatCourse;
use Illuminate\Http\Request;

class CoursePrivatController extends Controller
{
    private $dataPrivatCourse;

    public function __construct(DataPrivatCourse $dataPrivatCourse)
    {
        $this->dataPrivatCourse = $dataPrivatCourse;
    }

    public function index()
    {
        $coursePrivatDatas = $this->dataPrivatCourse->get();
        return view('course_private.index', compact('coursePrivatDatas'));
    }

    public function store(Request $request)
    {
        $this->dataPrivatCourse->create([
            'name' => $request->name,
            'email' => $request->email,
            'major' => $request->major,
            'institusi' => $request->institusi,
            'description_private_course' => $request->description_private_course,
            'teaching_private_course' => $request->teaching_private_course,
            'description_teaching_private_course' => $request->description_teaching_private_course,
            'deal_price_private_course' => $request->deal_price_private_course,
            'salary_teaching' => $request->salary_teaching,
            'net_funds_course' => $request->deal_price_private_course - $request->salary_teaching,
        ]);

        return redirect()->route('courseprivate.index')->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {

        $dataPrivatCourse = $this->dataPrivatCourse->find($id);
        $dataPrivatCourse->update([
            'name' => $request->name,
            'email' => $request->email,
            'major' => $request->major,
            'institusi' => $request->institusi,
            'description_private_course' => $request->description_private_course,
            'teaching_private_course' => $request->teaching_private_course,
            'description_teaching_private_course' => $request->description_teaching_private_course,
            'deal_price_private_course' => $request->deal_price_private_course,
            'salary_teaching' => $request->salary_teaching,
            'net_funds_course' => $request->deal_price_private_course - $request->salary_teaching,
        ]);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $dataPrivatCourse = $this->dataPrivatCourse->find($id);
        $dataPrivatCourse->delete();

        return redirect()->route('courseprivate.index')->with('success', 'Data berhasil dihapus');
    }
}
