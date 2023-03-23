<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    // protected $fillable = [];
    protected $guarded  = [];
    public $timestamps = false;

    public function company(){
        return $this->belongsTo(Company::class);
    }

}
