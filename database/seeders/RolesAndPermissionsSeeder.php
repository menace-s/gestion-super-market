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
        // Créer des permissions
        Permission::create(['name' => 'Chauffeurs']);
        Permission::create(['name' => 'Ajouter Chauffeurs']);
        Permission::create(['name' => 'Modifier chauffeurs']);
        Permission::create(['name' => 'Supprimer chauffeurs']);
        Permission::create(['name' => 'Usagers']);
        Permission::create(['name' => 'Modifier usagers']);
        Permission::create(['name' => 'Ajouter usagers']);
        Permission::create(['name' => 'Supprimer usagers']);
        Permission::create(['name' => 'Qr-code']);
        Permission::create(['name' => 'Transactions']);
        Permission::create(['name' => 'Paiements']);
        Permission::create(['name' => 'Permission & rôle']);
        Permission::create(['name' => 'Attribution rôle']);
        Permission::create(['name' => 'Ajouter un rôle']);
        Permission::create(['name' => 'Modifier un rôle']);
        Permission::create(['name' => 'Supprimer un rôle']);
        Permission::create(['name' => 'utilisateurs']);
        Permission::create(['name' => 'Ajouter un utilisateur']);
        Permission::create(['name' => 'Modifier un utilisateur']);
        Permission::create(['name' => 'Supprimer un utilisateur']);
        Permission::create(['name' => 'profil']);
        Permission::create(['name' => 'support']);
        Permission::create(['name' => 'documentation']);
        Permission::create(['name' => 'notification']);

        // Créer des rôles et attribuer des permissions
        $roleSuperAdmin = Role::create(['name' => 'SuperAdmin']);

        // Attribuer des permissions aux rôles
        $roleSuperAdmin->givePermissionTo([
            'Chauffeurs', 'Usagers',  'Qr-code', 'Transactions', 'notification', 'utilisateurs',
            'profil', 'support', 'documentation'  ,  'Paiements', 'Permission & rôle' , 'Attribution rôle',
        ]);
    }
}
