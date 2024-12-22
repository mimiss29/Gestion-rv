<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slot;
use App\Models\User;
use App\Models\Medecin;

class SlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            // Récupérer tous les médecins
            $medecins = Medecin::all();

            // Créer des créneaux horaires pour chaque médecin
            foreach ($medecins as $medecin) {
                Slot::factory()->count(5)->create([
                    'medecin_id' => $medecin->id,
                ]);
            }
        }
    }

