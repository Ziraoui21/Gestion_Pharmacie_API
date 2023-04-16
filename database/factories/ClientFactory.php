<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'genre' => $this->faker->randomElement(['homme','femme']),
            'tele' => "0{$this->faker->randomElement(['6','5','7'])}{$this->faker->randomNumber(8)}"
        ];
    }
}
