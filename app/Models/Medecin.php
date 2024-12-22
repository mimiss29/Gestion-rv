<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends User
{  
    use HasFactory;
    
    

    protected $table = 'users';
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('type',function ($builder) {
            $builder->where('type','Medecin');
        });
    }

     // Relation avec Specialite (un médecin a une seule spécialité)
     
     public function specialite()
     {
         return $this->belongsTo(Specialite::class, 'specialite_id');
     }
     // Relation avec SalleDeConsultation (un médecin peut avoir plusieurs salles de consultation)
     public function sallesDeConsultation()
     {
         return $this->belongsToMany(SalleDeConsultation::class);
     }

}
