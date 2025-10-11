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


             // Créer un utilisateur admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'adminnistrateur',
                'email' => 'admin@admin.com',
                'password' => bcrypt('Bonjour@2025'),
                'phone' =>'+2250555129163',
            ]
        );


         // Assigner le rôle admin à cet utilisateur
         $superAdmin->assignRole('superAdmin');


    }
}
