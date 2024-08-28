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
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
