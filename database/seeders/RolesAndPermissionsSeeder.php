<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BONNE PRATIQUE : Réinitialiser le cache des permissions et des rôles
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Créer les Permissions ---

        // Permissions pour le Tableau de Bord
        Permission::create(['name' => 'voir tableau de bord']);

        // Permissions pour les Produits
        Permission::create(['name' => 'voir produits']);
        Permission::create(['name' => 'créer produits']);
        Permission::create(['name' => 'modifier produits']);
        Permission::create(['name' => 'supprimer produits']);
        Permission::create(['name' => 'voir prix achat']); // Permission sensible

        // Permissions pour les Catégories
        Permission::create(['name' => 'gérer catégories']);

        // Permissions pour les Fournisseurs
        Permission::create(['name' => 'gérer fournisseurs']);
        
        // Permissions pour les Commandes (future fonctionnalité)
        Permission::create(['name' => 'gérer commandes fournisseurs']);

        // Permissions pour l'Administration
        Permission::create(['name' => 'gérer utilisateurs']);
        Permission::create(['name' => 'gérer rôles et permissions']);

        // --- Créer les Rôles ---
        $roleStockManager = Role::create(['name' => 'Responsable Stocks']);
        $roleAdmin = Role::create(['name' => 'Administrateur']);

        // --- Attribuer les Permissions aux Rôles ---

        // Le Responsable des Stocks a accès à tout ce qui est opérationnel
        $roleStockManager->givePermissionTo([
            'voir tableau de bord',
            'voir produits',
            'créer produits',
            'modifier produits',
            'supprimer produits',
            'voir prix achat',
            'gérer catégories',
            'gérer fournisseurs',
            'gérer commandes fournisseurs',
        ]);

        // L'Administrateur a accès à TOUT
        // La méthode givePermissionTo(Permission::all()) est un raccourci de pro.
        $roleAdmin->givePermissionTo(Permission::all());
    }
}