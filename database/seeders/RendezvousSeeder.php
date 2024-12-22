<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rendezvous;
use App\Models\User; 

class RendezvousSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Récupérer un médecin et un patient existants
         $medecin = User::where('type', 'Medecin')->first();
         $patient = User::where('type', 'Patient')->first();
 
         if ($medecin && $patient) {
             // Création de rendez-vous fictifs
             Rendezvous::create([
                 'medecin_id' => $medecin->id,
                 'patient_id' => $patient->id,
                 'date' => now()->addDays(1)->toDateString(), // Demain
                 'heure' => '10:30:00',
                 'lieu' => 'Cabinet du Dr ' . $medecin->nom,
                 'status' => 'Confirmé',
             ]);
 
             Rendezvous::create([
                 'medecin_id' => $medecin->id,
                 'patient_id' => $patient->id,
                 'date' => now()->addDays(2)->toDateString(), // Après-demain
                 'heure' => '14:00:00',
                 'lieu' => 'Cabinet du Dr ' . $medecin->nom,
                 'status' => 'En attente',
             ]);
 
             Rendezvous::create([
                 'medecin_id' => $medecin->id,
                 'patient_id' => $patient->id,
                 'date' => now()->addDays(3)->toDateString(), // Dans 3 jours
                 'heure' => '16:00:00',
                 'lieu' => 'Hôpital Général',
                 'status' => 'Annulé',
             ]);
         } else {
             // Affiche un message si aucun médecin ou patient n'est trouvé
             echo "Aucun médecin ou patient trouvé pour créer des rendez-vous.\n";
         }
     }
    }

