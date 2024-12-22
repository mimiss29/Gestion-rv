<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalleDeConsultation extends Model
{
    use HasFactory;
    protected $table = 'salle_de_consultations';

    // Spécifiez les colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'nom',
        'localisation',
    ];
    
}
