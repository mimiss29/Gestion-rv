<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends User
{  
    use HasFactory;
    
    protected $fillable = [];

    protected $table = 'users';
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('type',function ($builder) {
            $builder->where('type','Administrateur');
        });
    }
}
