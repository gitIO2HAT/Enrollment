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
        // Log the incoming request data
        Log::info('Add College Request:', $request->all());
    
        // Validation
        $request->validate([
            'college' => 'required|string|max:10|unique:colleges,college', // Ensures exactly 10 characters
            'description' => 'required|string|max:100', // Ensures exactly 100 characters
        ], [
            'college.max' => 'The college name must be exactly 10 characters.',
            'description.max' => 'The description must be exactly 100 characters.',
            'college.unique' => 'This college name has already been taken.',
        ]);
    
        // Log before creating the college
        Log::info('Creating a new College record.');
    
        $college = new College;
        $college->college = $request->college;
        $college->description = $request->description; // Ensure this line exists
    
        // Log the college data before saving
        Log::info('College Data:', [
            'college' => $college->college,
            'description' => $college->description,
        ]);
    
        $college->save();
    
        // Log successful save
        Log::info('College successfully added.');
    
        return redirect()->back()->with('success', 'College successfully added');
    }
    

    public function addcourse(Request $request)
    {
        $request->validate([
            'course' => 'required|string|max:100|unique:courses,course',
            'college_id' => 'required|integer|exists:colleges,id',
        ], [
            'course.required' => 'The course name field is required.',
            'course.max' => 'The course must be exactly 100 characters.',
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
            'major.max' => 'The major must be exactly 100 characters.',
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
            'college.max' => 'The college name must be exactly 10 characters.',
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
        Log::info('Edit Course Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);
        $request->validate([
            'course' => 'nullable|string|max:100|unique:courses,course,' . $id,
        ], [
            'course.max' => 'The course name must be exactly 100 characters.',
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

    public function editmajor($id, Request $request)
    {
        // Log incoming request data
        Log::info('Edit Major Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);
        $request->validate([
            'major' => 'nullable|string|max:100|unique:majors,major,' . $id,
        ], [
            'major.max' => 'The major name must be exactly 100 characters.',
            'major.unique' => 'This course name has already been taken.',
        ]);
        $major = Major::find($id);
        // Log current state of the college record
        Log::info('Current major Record:', [
            'major' => $major
        ]);
        if (!$major) {
            Log::error('major not found with ID: ' . $id);
            return redirect()->back()->with('error', 'major not found');
        }
        $major->major = $request->major;

        // Log updated values before saving
        Log::info('Updating major Record:', [
            'major' => $major
        ]);
        $major->save();
        // Log success message
        Log::info('major successfully updated with ID: ' . $id);
        return redirect()->back()->with('success', 'Major successfully updated');
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
    public function deletemajor($id){
        $major = Major::getId($id);

        $major->deleted = 2;
        $major->save();
        return redirect()->back()->with('success', 'Major successfully DELETED');
    }
}
