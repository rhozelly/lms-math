<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'sex',
        'birth',
        'phone',
        'parent_phone',
        'branch_id',
        'role_id',
        'grade_id',
        'activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function studentInfo(){
        return $this->hasOne(StudentInfo::class,'user_id');
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public static function teachers(){
        $role = Role::where('name','강사')->first();
        return User::where('role_id',$role->id)->get();
    }

    public static function students(){
        $role = Role::where('name','학생')->first();
        return User::where('role_id',$role->id)->get();
    }

    public static function numOfAdmin(){
        $role = Role::where('name','관리자')->first();
        return [
            'title'=>'관리자',
            'total'=>User::where('role_id',$role->id)->count()
        ];
    }

    public static function numOfTeachers(){
        $role = Role::where('name','강사')->first();
        return [
            'title'=>'강사',
            'total'=>User::where('role_id',$role->id)->count()
        ];
    }

    public static function numOfStudents(){
        $role = Role::where('name','학생')->first();
        return [
            'title'=>'학생',
            'total'=>User::where('role_id',$role->id)->count()
        ];
    }
}
