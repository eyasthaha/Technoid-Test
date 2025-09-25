<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

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
