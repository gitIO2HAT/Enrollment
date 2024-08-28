<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Major;

class CollegeController extends Controller
{
    public function college(Request $request)
    {
        if (Auth::check() && Auth::user()->user_type == 0) {
            $colleges = College::where('deleted', '1')->get();
            $courses = Course::where('deleted', '1')->get();
            $majors = Major::where('deleted', '1')->get();

            return view('superadmin.college', [
                'colleges' => $colleges,
                'courses' => $courses,
                'majors' => $majors,
            ]);
        }
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    public function addcollege(Request $request)
    {
        $request->validate([
            'college' => 'required|string|max:100|unique:colleges,college',
        ], [
            'college.unique' => 'This college name has already been taken.',
        ]);

        $college = new College;
        $college->college = $request->college;
        $college->description = $request->description;
        $college->save();

        return redirect()->back()->with('success', 'College successfully added');
    }

    public function addcourse(Request $request)
    {
        $request->validate([
            'course' => 'required|string|max:100|unique:courses,course',
            'college_id' => 'required|integer|exists:colleges,id',
        ], [
            'course.required' => 'The course name field is required.',
            'course.unique' => 'This course name has already been taken.',
            'college_id.required' => 'The college field is required.',
            'college_id.exists' => 'The selected college is invalid.',
        ]);

        $course = new Course;
        $course->course = $request->course;
        $course->college_id = $request->college_id;

        $course->save();

        return redirect()->back()->with('success', 'Course successfully added');
    }

    public function addmajor(Request $request)
    {
        $request->validate([
            'major' => 'required|string|max:50|unique:majors,major',
            'course_id' => 'required|integer|exists:courses,id',
        ], [
            'major.required' => 'The major name field is required.',
            'major.unique' => 'This major name has already been taken.',
            'course_id.required' => 'The course field is required.',
            'course_id.exists' => 'The selected course is invalid.',
        ]);

        $major = new Major;
        $major->major = $request->major;
        $major->course_id = $request->course_id;

        $major->save();

        return redirect()->back()->with('success', 'Major successfully added');
    }

    public function editcollege($id, Request $request)
    {
        // Log incoming request data
        Log::info('Edit College Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);
        $request->validate([
            'college' => 'nullable|string|max:50|unique:colleges,college,' . $id,
            'description' => 'nullable|string|max:255',
        ], [
            'college.unique' => 'This college name has already been taken.',
        ]);
        $college = College::find($id);
        // Log current state of the college record
        Log::info('Current College Record:', [
            'college' => $college
        ]);
        if (!$college) {
            Log::error('College not found with ID: ' . $id);
            return redirect()->back()->with('error', 'College not found');
        }
        $college->college = $request->college;
        $college->description = $request->description;
        // Log updated values before saving
        Log::info('Updating College Record:', [
            'college' => $college
        ]);
        $college->save();
        // Log success message
        Log::info('College successfully updated with ID: ' . $id);
        return redirect()->back()->with('success', 'College successfully updated');
    }
    public function editcourse($id, Request $request)
    {
        // Log incoming request data
        Log::info('Edit College Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);
        $request->validate([
            'course' => 'nullable|string|max:50|unique:courses,course,' . $id,
        ], [
            'course.unique' => 'This course name has already been taken.',
        ]);
        $course = Course::find($id);
        // Log current state of the college record
        Log::info('Current course Record:', [
            'course' => $course
        ]);
        if (!$course) {
            Log::error('course not found with ID: ' . $id);
            return redirect()->back()->with('error', 'course not found');
        }
        $course->course = $request->course;

        // Log updated values before saving
        Log::info('Updating course Record:', [
            'course' => $course
        ]);
        $course->save();
        // Log success message
        Log::info('course successfully updated with ID: ' . $id);
        return redirect()->back()->with('success', 'Course successfully updated');
    }

    public function deletecollege($id){
        $college = College::getId($id);

        $college->deleted = 2;
        $college->save();
        return redirect()->back()->with('success', 'College successfully DELETED');
    }
    public function deletecourse($id){
        $course = Course::getId($id);

        $course->deleted = 2;
        $course->save();
        return redirect()->back()->with('success', 'Course successfully DELETED');
    }
}
