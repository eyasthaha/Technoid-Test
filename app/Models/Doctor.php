<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'clinic_id',
        'name',
        'speciality',
        'status',
    ];
}
