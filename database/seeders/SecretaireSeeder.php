<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Secretaire;

class SecretaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Secretaire::create([
            'nom' => 'Diarietou',
            'prenom' => 'gaye',
            'adresse' => '123 Rue Exemple, Paris',
            'sexe' => 'M',
            'email' => 'diarietou@example.com',
            'telephone' => '0123456789',
            'mdp' => bcrypt('password123'),  // Sécuriser le mot de passe
            'type' => 'Secretaire',
            'specialite' => null,
            'cabinet' => null,
            'group_sanguin' => null  ,
            'medecin_id' => 1  ,
        ]);
    }
}
