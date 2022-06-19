<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facture>
 */
class FactureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id' => $this->faker->numberBetween(1,50),
            'prix_avance' => $this->faker->numberBetween(10,200),
            'date_facture' => $this->faker->dateTimeBetween('01/01/2015'),
            'heure_facture' => $this->faker->time()
        ];
    }
}
