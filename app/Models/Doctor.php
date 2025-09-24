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

    public function user()
    {
        return $this->morphOne(Entity::class, 'model');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
