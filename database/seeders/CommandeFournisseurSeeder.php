<?php

namespace Database\Seeders;

use App\Models\CommandeFournisseur;
use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommandeFournisseurSeeder extends Seeder
{
    public function run(): void
    {
        // On s'assure qu'il y a des produits à commander
        if (Produit::count() == 0) {
            $this->command->info('Aucun produit trouvé, veuillez d\'abord lancer le seeder des produits.');
            return;
        }

        // On crée 20 commandes
        CommandeFournisseur::factory()
            ->count(20)
            ->create()
            ->each(function ($commande) {
                // Pour chaque commande, on attache entre 1 et 5 produits au hasard
                $produits = Produit::inRandomOrder()->limit(rand(1, 5))->get();
                $totalCommande = 0;

                foreach ($produits as $produit) {
                    $quantite = rand(5, 20);
                    // On utilise le prix d'achat du produit comme base
                    $prixUnitaire = $produit->prix_achat; 
                    $totalCommande += $quantite * $prixUnitaire;

                    // On attache le produit à la commande avec les données de la table pivot
                    $commande->produits()->attach($produit->id, [
                        'quantite_commandee' => $quantite,
                        'prix_unitaire' => $prixUnitaire,
                    ]);
                }

                // On met à jour le total de la commande
                $commande->total = $totalCommande;
                $commande->save();
            });
    }
}