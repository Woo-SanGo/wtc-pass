<?php

// app/Models/AdoptionApplication.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'pet_name', 'reason',
    ];
}
