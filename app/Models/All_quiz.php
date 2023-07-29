<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class All_quiz extends Model
{
    use HasFactory;

    protected $guarded = [];




    public function quistions(){

        return $this->hasMany(All_quistion::class);
    }
}
