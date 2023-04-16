<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fournisseur>
 */
class FournisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom_f' => $this->faker->company(),
            'tele' => "0{$this->faker->randomElement(['6','5','7'])}{$this->faker->randomNumber(8)}",
            'email' => $this->faker->companyEmail(),
            'adresse' => $this->faker->address()
        ];
    }
}
