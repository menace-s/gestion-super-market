<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categorie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prixAchat = $this->faker->randomFloat(2, 5, 100);
        return [
            'sku' => $this->faker->unique()->bothify('SKU-####??'), // Génère un SKU unique
            'name' => $this->faker->words(3, true), 
            'category_id' => Categorie::factory(),
            'description' => $this->faker->sentence(10), // Génère une phrase
            'prix_achat' =>$prixAchat, 
            'prix_vente' => $prixAchat + $this->faker->randomFloat(2, 5, 50),
            'quantity' => $this->faker->numberBetween(0, 100),
            'min_stock' => $this->faker->numberBetween(1, 10), 
            'image_path' => null,
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
