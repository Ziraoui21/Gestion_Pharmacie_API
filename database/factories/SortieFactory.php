<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sortie>
 */
class SortieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'medicament_id' => $this->faker->numberBetween(1,90),
            'qte' => $this->faker->numberBetween(1,3),
            'date_sortie' => $this->faker->dateTimeBetween('01/01/2015')
        ];
    }
}
