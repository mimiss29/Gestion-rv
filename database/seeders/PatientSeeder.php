<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            'nom' => 'Diaaw',
            'prenom' => 'faye',
            'adresse' => '123 Rue Exemple, Paris',
            'sexe' => 'M',
            'email' => 'didi@example.com',
            'telephone' => '0123456789',
            'mdp' => bcrypt('password123'),  // Sécuriser le mot de passe
            'type' => 'Patient',
            'specialite' => null,
            'cabinet' => null,
            'group_sanguin' => '0+'  ,
            'medecin_id' => null  ,
        ]);

        
    }
}
