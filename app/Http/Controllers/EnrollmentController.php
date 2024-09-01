<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\College;
use App\Models\Course;
use App\Models\Major;
use App\Models\Semester;
use App\Models\Student;
use App\Models\YearLevel;
use App\Models\Suffix;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class EnrollmentController extends Controller
{
    public function enrollment(Request $request)
{
    $yearlevels = YearLevel::all();
    $years = YearLevel::whereNot('id', '=', 6)->get();
    $semester = Semester::all();
    $suffixs = Suffix::all();


    $query = Student::with(['college', 'course', 'major', 'yearlevel', 'semesters', 'awards','fix'])
        ->whereNot('year_level', '=', 6)
        ->where('deleted', '=', 1);

    // Apply filters
    if ($request->has('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function($q) use ($searchTerm) {
            $q->where('firstname', 'LIKE', $searchTerm)
              ->orWhere('lastname', 'LIKE', $searchTerm)
              ->orWhere('middlename', 'LIKE', $searchTerm)
              ->orWhere('student_Id', 'LIKE', $searchTerm);
        });
    }

    if ($request->has('collegeId')) {
        $query->where('collegeId', $request->collegeId);
    }

    if ($request->has('courseId')) {
        $query->where('courseId', $request->courseId);
    }

    if ($request->has('majorId')) {
        $query->where('majorId', $request->majorId);
    }

    if ($request->has('yearLevelId')) {
        $query->where('year_level', $request->yearLevelId);
    }

    if ($request->has('semesterId')) {
        $query->where('semester', $request->semesterId);
    }

    // Paginate the filtered results
    $studentdata = $query->paginate(10);

    // Determine view path based on user type
    $viewPath = Auth::user()->user_type == 0 ? 'superadmin.enrollment' : '';

    return view($viewPath, [
        'studentdata' => $studentdata,
        'yearlevels' => $yearlevels,
        'years' => $years,
        'suffixs' => $suffixs,
        'semester' => $semester

    ]);
}

public function student($id)
{
    $yearlevel = YearLevel::all();
    $semester = Semester::all();
    $award = Award::all();
    $suffixs = Suffix::all();

    $studentdata = Student::with(['college', 'course', 'major','yearlevel','semesters','awards','fix'])
    ->where('id',$id)
    ->where('deleted', '=', 1)
    ->first();



$viewPath = Auth::user()->user_type == 0
        ? 'superadmin.editstudent'
        : '' ;
    return view($viewPath, ['studentdata'=> $studentdata,
    'yearlevel'=> $yearlevel,
    'award'=> $award,
    'suffixs'=> $suffixs,
    'semester'=> $semester
    ]
    );
}


public function addstudent(Request $request)
{
     // Create a new user instance
     $student = new Student;

    $request->validate([
        'firstname' => 'required|string|max:30',
        'lastname' => 'required|string|max:30',
        'middlename' => 'nullable|string|max:30',
        'sex' => 'required|in:1,2,3',
        'collegeId' => 'required|integer',
        'courseId' => 'required|integer',
        'majorId' => 'required|integer',
        'year_level' => 'required|integer',
        'academic_year_start' => 'required|integer',
        'academic_year_end' => 'required|integer',
        'semester' => 'required|integer',
        'suffix' => 'nullable|integer',
    ],[
        'firstname.required' => 'The first name field is required.',
        'lastname.required' => 'The last name field is required.',
        'sex.required' => 'The sex field is required.',
        'collegeId.required' => 'The college field is required.',
        'courseId.required' => 'The course field is required.',
        'majorId.required' => 'The major field is required.',
        'year_level.required' => 'The year level field is required.',
        'semester.required' => 'The semester field is required.',
        'academic_year_start.required' => 'The academic year field is required.',
        'academic_year_end.required' => 'The academic year field is required.',

    ]);

    // Assign values to user properties
    $student->firstname = $request->firstname;
    $student->lastname = $request->lastname;
    $student->middlename = $request->middlename;
    $student->sex = $request->sex;
    $student->collegeId = $request->collegeId;
    $student->courseId = $request->courseId;
    $student->majorId = $request->majorId;
    $student->year_level = $request->year_level;
    $student->semester = $request->semester;
    $student->academic_award = 4;
    $student->academic_year_start = $request->academic_year_start;
    $student->academic_year_end = $request->academic_year_end;
    $student->suffix = $request->suffix;

    // Generate custom ID
    $currentYear = Carbon::now()->format('Y');
    $latestUserId = Student::latest('id')->first(); // Get the latest user ID
    $nextUserId = ($latestUserId) ? $latestUserId->id + 1 : 1; // Increment the latest user ID
    $student_Id = $currentYear . '-' . sprintf('%05d', $nextUserId); // Format the custom ID

    // Assign the custom ID to the user
    $student->student_Id = $student_Id;
    // Save the user to the database
    $student->save();

    return redirect()->back()->with('success', 'Student successfully added');
}

public function editstudent($id, Request $request){

    $student = Student::getId($id);

    $request->validate([
        'firstname' => 'required|string|max:30',
        'lastname' => 'required|string|max:30',
        'middlename' => 'nullable|string|max:30',
        'sex' => 'required|in:1,2,3',
        'collegeId' => 'nullable|integer',
        'courseId' => 'nullable|integer',
        'majorId' => 'nullable|integer',
        'year_level' => 'required|integer',
        'academic_year_start' => 'required|integer',
        'academic_year_end' => 'required|integer',
        'semester' => 'required|integer',
        'suffix' => 'nullable|integer',
    ],[
        'firstname.required' => 'The first name field is required.',
        'lastname.required' => 'The last name field is required.',

        'year_level.required' => 'The year level field is required.',
        'semester.required' => 'The semester field is required.',
        'academic_year_start.required' => 'The academic year field is required.',
        'academic_year_end.required' => 'The academic year field is required.',

    ]);

    // Assign values to user properties
    $student->firstname = $request->firstname;
    $student->lastname = $request->lastname;
    $student->middlename = $request->middlename;
    $student->sex = $request->sex;
    $student->collegeId = $request->collegeId;
    $student->courseId = $request->courseId;
    $student->majorId = $request->majorId;
    $student->year_level = $request->year_level;
    $student->semester = $request->semester;
    $student->academic_award = $request->academic_award;
    $student->academic_year_start = $request->academic_year_start;
    $student->academic_year_end = $request->academic_year_end;
    $student->suffix = $request->suffix;

    // Generate custom ID

    // Save the user to the database
    $student->save();

    return redirect('/SuperAdmin/Enrollment')->with('success', 'Student successfully updated');

}

public function getColleges()
{
    $collegess = College::where('deleted', '1')->get();
    return response()->json($collegess);
}

public function getCourses($college_id)
{
    $coursess = Course::where('college_id', $college_id)
                     ->where('deleted', '1')
                     ->get();
    return response()->json($coursess);
}

public function getMajors($course_id)
{
    $majorss = Major::where('course_id', $course_id)
                   ->where('deleted', '1')
                   ->get();
    return response()->json($majorss);
}
}
