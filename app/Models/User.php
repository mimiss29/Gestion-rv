<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id', 'nom', 'prenom', 'adresse', 'sexe', 'email', 'telephone', 'mdp','type' , 'specialite_id' ,  'medecin_id','patient_id',

    ];

                public function rendezvousAsMedecin()
            {
                return $this->hasMany(Rendezvous::class, 'medecin_id');
            }

            public function rendezvousAsPatient()
            {
                return $this->hasMany(Rendezvous::class, 'patient_id');
            }
            // In User.php model
    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'specialite_id');
    }
   
   
  // Relation avec les créneaux de médecin
  public function medecinSlots()
  {
      return $this->hasMany(Slot::class, 'medecin_id');
  }

  // Relation avec les créneaux de patient
  public function patientSlots()
  {
      return $this->hasMany(Slot::class, 'patient_id');
  }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
