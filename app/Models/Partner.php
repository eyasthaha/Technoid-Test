<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'contact_email'
    ];

    public function clinic()
    {
        return $this->hasMany(Clinic::class);
    }

    public function doctors()
    {
        return $this->hasManyThrough(Doctor::class, Clinic::class);
    }
}
