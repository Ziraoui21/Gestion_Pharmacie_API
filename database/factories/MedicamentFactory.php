<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicament>
 */
class MedicamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'libelle' => $this->faker->company(),
            'prix_vente' => $this->faker->randomFloat(2,3,200),
            'prix_achat' => $this->faker->randomFloat(2,3,200),
            'qte_s' => $this->faker->numberBetween(5,200),
            'date_expiration' => $this->faker->dateTimeBetween('01/07/2019','01/01/2030'),
            'fournisseur_id' => $this->faker->numberBetween(1,90)
        ];
    }
}
