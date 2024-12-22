<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slot;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slot>
 */
class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Slot::class;

    public function definition()
    {
        return [
            'medecin_id' => User::where('type', 'Medecin')->inRandomOrder()->first()->id, // Assurez-vous qu'il y a des médecins dans la base de données
            'date_debut' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'date_fin' => $this->faker->dateTimeBetween('-1 month', '+1 month')->modify('+1 hour'),
            'statut' => $this->faker->randomElement(['disponible', 'réservé', 'annulé']),
            'est_reserve' => $this->faker->boolean,
            'patient_id' => User::where('type', 'Patient')->inRandomOrder()->first()?->id, // Assurez-vous qu'il y a des patients dans la base de données
        ];
    }
}
