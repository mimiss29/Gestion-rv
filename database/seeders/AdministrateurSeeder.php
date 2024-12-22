<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrateur;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrateur::create([
            'nom' => 'Diallo',
            'prenom' => 'Johnn',
            'adresse' => '123 Rue Exemple, Paris',
            'sexe' => 'M',
            'email' => 'fatdiopdiallo@example.com',
            'telephone' => '0123456789',
            'mdp' => bcrypt('password123'),  // Sécuriser le mot de passe
            'type' => 'Administrateur',
            'specialite' => null,
            'cabinet' => null,
            'group_sanguin' => null  ,
            'medecin_id' => null  ,
        ]);

    }
}
