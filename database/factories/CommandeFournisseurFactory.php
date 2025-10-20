<?php

namespace Database\Factories;

use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommandeFournisseurFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Associe la commande à un fournisseur existant au hasard
            'fournisseur_id' => Fournisseur::inRandomOrder()->first()->id,

            // Génère une référence unique, ex: CMD-2025-ABCDE123
            'reference' => 'CMD-' . now()->year . '-' . Str::random(8),

            'date_commande' => $this->faker->dateTimeBetween('-2 months', 'now'),

            // Choisit un statut au hasard parmi ceux définis
            'statut' => $this->faker->randomElement(['brouillon', 'envoyee', 'receptionnee', 'annulee']),

            // Le total sera calculé plus tard, on le laisse à 0 pour l'instant
            'total' => 0, 

            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}