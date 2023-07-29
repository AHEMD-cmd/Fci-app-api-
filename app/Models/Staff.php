<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory, HasApiTokens;

    protected $guarded = [];

    public function department(){

        return $this->belongsTo(Department::class);
    }
}
