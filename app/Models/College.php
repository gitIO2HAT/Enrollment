<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $fillable = ['college', 'description','deleted'];


    public function course()
    {
        return $this->hasMany(Course::class);
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
