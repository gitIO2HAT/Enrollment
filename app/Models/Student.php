<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    use HasFactory;

    public $table = 'students';

    protected $fillable = [
        'student_Id',
        'firstname',
        'lastname',
        'middlename',
        'collegeId',
        'courseId',
        'majorId',
        'year_level',
        'semester',
        'academic_year_start',
        'academic_year_end',
        'suffix',
        'academic_award',
        'deleted',
        'sex',
    ];

    static public function getID($id)
    {
        return self::find($id);
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'collegeId');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'majorId');
    }
    public function yearlevel()
    {
        return $this->belongsTo(YearLevel::class, 'year_level');
    }
    public function semesters()
    {
        return $this->belongsTo(Semester::class, 'semester');
    }
    public function awards()
    {
        return $this->belongsTo(Award::class, 'academic_award');
    }
    public function fix()
    {
        return $this->belongsTo(Suffix::class, 'suffix');
    }

}
