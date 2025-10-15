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
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'contact_name' => $this->faker->name(),
            
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'adress' => $this->faker->address(),
        ];
    }
}
