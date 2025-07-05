<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetInformation extends Model
{
    use HasFactory;

    protected $table = 'pet_information'; // 👈 VERY IMPORTANT

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

    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }
}
