<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    public $table = 'awards';
    protected $fillable = ['status'];
    public function users()
    {
        return $this->hasMany(Student::class);
    }
}
