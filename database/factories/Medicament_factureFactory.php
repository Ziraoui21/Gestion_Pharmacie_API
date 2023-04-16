<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicament_facture>
 */
class Medicament_factureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'medicament_id' => $this->faker->randomNumber(1,2000),
            'facture_id' => $this->faker->randomNumber(1,50),
            'qte' => $this->faker->numberBetween(1,3),
        ];
    }
}
