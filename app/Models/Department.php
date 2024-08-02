<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
    static public function getId($id)
    {
        return self::find($id);
    }
}
