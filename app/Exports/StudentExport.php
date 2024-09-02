<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $studentIds;

    public function __construct(array $studentIds)
    {
        $this->studentIds = $studentIds;
    }

    public function collection()
    {
        $students = Student::whereIn('id', $this->studentIds)
            ->with(['college', 'course', 'major', 'yearlevel', 'semesters', 'awards', 'fix'])
            ->get();

        $data = $students->map(function ($student) {
            $sex = null;
            if ($student->sex == '1') {
                $sex = 'Female';
            } elseif ($student->sex == '2') {
                $sex = 'Male';
            } elseif ($student->sex == '3') {
                $sex = 'Prefer not to say';
            }
            return [
                'Student ID' => $student->student_Id,
                'First Name' => $student->firstname,
                'Last Name' => $student->lastname,
                'Middle Name' => $student->middlename,
                'Suffix' => $student->fix->status ?? '', // Check if the relation exists
                'Sex' => $sex,
                'College' => $student->college->college ?? '', // Check if the relation exists
                'Course' => $student->course->course ?? '', // Check if the relation exists
                'Major' => $student->major->major ?? '', // Check if the relation exists
                'Year Level' => $student->yearlevel->status ?? '', // Check if the relation exists
                'Semester' => $student->semesters->status ?? '', // Check if the relation exists
                'Awards' => $student->awards->status ?? '', // Check if the relation exists
                'Academic Start' => $student->academic_year_start,
                'Academic End' => $student->academic_year_end,
                // Add other columns as needed
            ];
        });

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'First Name',
            'Last Name',
            'Middle Name',
            'Suffix',
            'Sex',
            'College',
            'Course',
            'Major',
            'Year Level',
            'Semester',
            'Awards',
            'Academic Start',
            'Academic End',
            // Add other columns as needed
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'FFFF00']]], // Yellow color for header
        ];
    }
}
