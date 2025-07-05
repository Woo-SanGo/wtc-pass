<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        // add other columns that you want to allow mass assignment
    ];
}