<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $table = 'users';
    protected $fillable = [
        'name',
        'username',
        'email',
        'user_type',
        'password',
        'sex',
        'admin_id',
        'deleted',
        'role',
        'questions',
        'answer',
        'profile_pic',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function active()
    {
        return self::where('user_type', '=', 1)
            ->where('deleted', '=', 1);
    }

    public static function offline()
    {
        return self::where('user_type', '=', 2)
            ->where('deleted', '=', 2);
    }
    static public function getID($id)
    {
        return self::find($id);
    }
}
