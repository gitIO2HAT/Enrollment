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
    public function users()
    {
        return $this->hasMany(User::class);
    }
    static public function getID($id)
    {
        return self::find($id);
    }
}
