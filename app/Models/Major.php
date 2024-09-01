<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'major','deleted'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    static public function getID($id)
    {
        return self::find($id);
    }
}
