<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Student;
use App\Models\YearLevel;
use App\Models\Suffix;


class GraduateController extends Controller
{
    public function graduate(Request $request)
    {

        $yearlevels = YearLevel::all();
        $semester = Semester::all();
        $awards = Award::all();
        $suffixs = Suffix::all();

        $query = Student::with(['college', 'course', 'major', 'yearlevel', 'semesters', 'awards','fix'])
        ->where('year_level', '=', 6)
        ->where('deleted', '=', 1);

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

        if ($request->has('awardsId')) {
            $query->where('academic_award', $request->awardsId);
        }

        // Paginate the filtered results
        $studentdata = $query->paginate(10);


    $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.graduate'
            : '' ;
        return view($viewPath,['studentdata'=> $studentdata,
        'yearlevels'=> $yearlevels,
        'awards'=> $awards,
        'suffixs'=> $suffixs,
        'semester'=> $semester]
        );
    }
}
