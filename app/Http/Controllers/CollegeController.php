<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\College;
use App\Models\Course;
use App\Models\Major;
use Carbon\Carbon;

class CollegeController extends Controller
{
    public function college(Request $request)
    {
        // Check if the user is authenticated and is a super admin
        if (Auth::check() && Auth::user()->user_type == 0) {
            // Fetch all colleges from the database
            $colleges = College::all();
            $courses = Course::all();
            $majors = Major::all(); // Consider using paginate if there are many colleges

            // Render the superadmin.college view with the colleges data
            return view('superadmin.college', [
                'colleges' => $colleges,
                'courses' => $courses,
                'majors' => $majors,
            ]);
        }
        // Redirect to home with an error message if unauthorized
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }
   
    
    public function addcollege(Request $request)
    {
        $college = new College;
        $request->validate([
            'college' => 'string|max:50|unique:colleges,college',
        ], [
            'college.unique' => 'This name has already been taken.',
        ]);
        $college->college = $request->college;
        $college->description = $request->description;
        $college->save();
        return redirect()->back()->with('success', 'Department successfully added');
    }
    public function addcourse(Request $request)
    {
        $course = new Course;
        $request->validate([
            'course' => 'required|string|max:50|unique:courses,course',
            'college_id' => 'required|integer|exists:colleges,id',
        ], [
            'course.required' => 'The name field is required.',
            'course.unique' => 'This name has already been taken.',
            'college_id.required' => 'The department field is required.',
            'college_id.exists' => 'The selected department is invalid.',
        ]);
        $course->course = $request->course;
        $course->college_id = $request->college_id;
        $course->save();
        return redirect()->back()->with('success', 'Position successfully added');
    }
    public function addmajor(Request $request)
    {
        $major = new Major;
        $request->validate([
            'major' => 'required|string|max:50|unique:majors,major',
            'course_id' => 'required|integer|exists:courses,id',
        ], [
            'major.required' => 'The name field is required.',
            'major.unique' => 'This name has already been taken.',
            'course_id.required' => 'The department field is required.',
            'course_id.exists' => 'The selected department is invalid.',
        ]);
        $major->major = $request->major;
        $major->course_id = $request->course_id;
        $major->save();
        return redirect()->back()->with('success', 'Position successfully added');
    }
}
