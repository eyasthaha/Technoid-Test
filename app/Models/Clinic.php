<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = [
        'partner_id',
        'name',
        'city',
        'type',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
