<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    // protected $fillable = [];
    protected $guarded  = [];
    public $timestamps = false;

    public function teachers(){
        return $this->hasMany(Course::class,'teacher_id');
    }

    public function students(){
        return $this->hasMany(Course::class,'student_id');
    }

}
