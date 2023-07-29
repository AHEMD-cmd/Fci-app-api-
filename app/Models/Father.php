<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Father extends Model
{
    use HasFactory, HasApiTokens;

        protected $guarded = [];



}
