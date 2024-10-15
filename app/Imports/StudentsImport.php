<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Suffix;
use App\Models\YearLevel;
use App\Models\College;
use App\Models\Course;
use App\Models\Major;
use App\Models\Award;
use App\Models\Semester;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Generate a unique student ID for each student
        $currentYear = Carbon::now()->format('Y');
        $latestStudent = Student::latest('id')->first(); // Get the latest student
        $nextUserId = ($latestStudent) ? $latestStudent->id + 1 : 1; // Increment the latest user ID
        $student_Id = $currentYear . '-' . sprintf('%05d', $nextUserId); // Format the custom ID

        // Fetch related IDs based on the status
        $suffix = Suffix::where('status', $row['suffix'])->first();
        $year = YearLevel::where('status', $row['yearlevel'])->first();
        $collegeId = College::where('college', $row['college'])->first();
        $courseId = Course::where('course', $row['course'])->first();
        $majorId = Major::where('major', $row['major'])->first();
        $awardId = Award::where('status', $row['awards'])->first();
        $semesterId = Semester::where('status', $row['semester'])->first();
        // Handle sex value mapping
        $sex = null;
        if ($row['sex'] == 'Female') {
            $sex = 1;
        } elseif ($row['sex'] == 'Male') {
            $sex = 2;
        }
        return new Student([
            'student_Id'           => $student_Id,
            'firstname'            => $row['firstname'],
            'lastname'             => $row['lastname'],
            'middlename'           => $row['middlename'] ?? null,
            'suffix'               => $suffix ? $suffix->id : null, // Corresponds to suffix ID or null
            'sex'                  => $sex, // Sex value mapped correctly
            'collegeId'            => $collegeId ? $collegeId->id : null, // Corresponds to college ID or null
            'courseId'             => $courseId ? $courseId->id : null, // Corresponds to course ID or null
            'majorId'              => $majorId ? $majorId->id : null, // Corresponds to major ID or null
            'year_level'           => $year ? $year->id : null, // Corresponds to year level ID or null
            'semester'             => $semesterId ? $semesterId->id : null, // Corresponds to semester ID or null
            'academic_award'       => $awardId ? $awardId->id : null, // Corresponds to award ID or null
            'academic_year_start'  => $row['academic_start'],
            'academic_year_end'    => $row['academic_end'],
            'deleted'              => 1, // Set deleted status as required
        ]);
    }
}
