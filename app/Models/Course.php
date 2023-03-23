<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    // protected $fillable = [];
    protected $guarded  = [];

    public function student(){
        return $this->belongsTo(User::class,'student_id');
    }

    public function studentInfo(){
        return $this->hasOne(StudentInfo::class,'user_id','student_id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function courseDaysTimes(){
        return $this->hasOne(CourseDaysTimes::class);
    }
}
