<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MedecinSeeder;
use Database\Seeders\AdministrateurSeeder;
use Database\Seeders\SecretaireSeeder;
use Database\Seeders\PatientSeeder;
use Database\Seeders\RendezvousSeeder;
use Database\Seeders\SlotTableSeeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(PatientSeeder::class);
        $this->call(MedecinSeeder::class);
        $this->call(AdministrateurSeeder::class);
        $this->call(SecretaireSeeder::class);
        $this->call(RendezvousSeeder::class);
        $this->call([
            SlotTableSeeder::class,
        ]);
       
    }
}
