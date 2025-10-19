<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role; // Assurez-vous que le modèle Role est importé
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- 1. Création de l'Utilisateur ADMINISTRATEUR ---
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@g-stock.com'], // Clé unique pour la recherche
            [
                'name' => 'Admin G-Stock',
                'password' => bcrypt('password'), // Change ce mot de passe !
                'phone' => '+2250102030405',
            ]
        );
        // On assigne le rôle 'Administrateur'
        $adminUser->assignRole('Administrateur');


        // --- 2. Création de l'Utilisateur RESPONSABLE STOCKS ---
        $stockUser = User::updateOrCreate(
            ['email' => 'stock@g-stock.com'], // Clé unique pour la recherche
            [
                'name' => 'Responsable Stocks',
                'password' => bcrypt('password'), // Change ce mot de passe !
                'phone' => '+2250708091011',
            ]
        );
        // On assigne le rôle 'Responsable Stocks'
        $stockUser->assignRole('Responsable Stocks');
    }
}
