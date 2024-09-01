<?php

// In app/Models/Suffix.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suffix extends Model
{
    use HasFactory;

    public $table = 'suffix';
    protected $fillable = [
        'status',
    ];

    static public function getID($id)
    {
        return self::find($id);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
