<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){

        return $this->belongsToMany(User::class, 'course_users', 'user_id', 'course_id', 'id', 'id');
    }

}
