<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretaire extends User
{  
    use HasFactory;
    
    protected $fillable = ['medecin_id'];

    protected $table = 'users';
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('type',function ($builder) {
            $builder->where('type','Secretaire');
        });
    }
}
