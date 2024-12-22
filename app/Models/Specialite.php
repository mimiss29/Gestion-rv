<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $table = 'specialites';

    // Spécifiez les colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'nom',
        'description',
    ];

    // Relation avec Medecin (une spécialité peut avoir plusieurs médecins)
    public function medecins()
    {
        return $this->hasMany(Medecin::class);
    }
}
