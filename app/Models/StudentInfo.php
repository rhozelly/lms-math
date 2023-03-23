<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;
    // protected $fillable = [];
    protected $guarded  = [];
    public $timestamps = false;

    public function grade(){
        return $this->belongsTo(Grade::class);
    }
}
