<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    public $table = 'semesters';
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
