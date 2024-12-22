<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medecin;
use App\Models\Specialite;

class MedecinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialite = Specialite::firstOrCreate(['nom' => 'Cardiologie']);

        Medecin::create([
            'nom' => 'Kane',
            'prenom' => 'mamita',
            'adresse' => 'Dakar',
            'sexe' => 'M',
            'email' => 'mamita@gmail.com',
            'telephone' => '7745678349',
            'mdp' => bcrypt('password123'),  // Sécuriser le mot de passe
            'type' => 'Medecin',
            'specialite_id' => $specialite->id,
            'cabinet' => 'Cabinet de Cardiologie ',
            'group_sanguin' => null  ,
            'medecin_id' => null  ,
        ]);

       
    }
    
}
