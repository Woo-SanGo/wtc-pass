<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'age',
        'behavior',
        'description',
        'location',
        'shelter_id',
        'image',
    ];

    // Relationship to shelter (user with role = shelter)
    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }
}
