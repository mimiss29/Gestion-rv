<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendezvous extends Model
{
    use HasFactory;
    protected $table = 'rendezvouses';

    /**
     * Les attributs pouvant être remplis en masse.
     */
    protected $fillable = [
        'medecin_id',
        'patient_id',
        'date',
        'heure',
        'lieu',
        'status',
    ];

            public function medecin()
        {
            return $this->belongsTo(User::class, 'medecin_id');
        }

        public function patient()
        {
            return $this->belongsTo(User::class, 'patient_id');
        }
}
