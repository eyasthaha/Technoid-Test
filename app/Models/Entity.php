<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Entity extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'users';

     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'model_type',
        'model_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
