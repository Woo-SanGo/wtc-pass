<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterApplication extends Model
{
    use HasFactory;

    protected $fillable = [
    'organization_name',
    'email',
    'phone',
    'address',
    'proof_document',
    'message',
    'status',
    ];


}
