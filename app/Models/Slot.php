<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'medecin_id',
        'date_debut',
        'date_fin',
        'statut',
        'est_reserve',
        'patient_id',
    ];

    // Relation avec le modèle User (médecin)
    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    // Relation avec le modèle User (patient)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
