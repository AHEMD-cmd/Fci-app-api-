<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(){

        return $this->hasMany(User::class);
    }

    public function staff(){

        return $this->hasMany(Staff::class);
    }

    public function material(){

        return $this->hasMany(Material::class);
    }
}
