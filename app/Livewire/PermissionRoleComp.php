<?php

namespace App\Livewire;

use Log;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleComp extends Component
{

    use WithPagination;

    public $currentPage = PAGEROLE;
    public $name,
           $search = "",
           $editRoleId = null;

    public $visibilieModaleAdd = false;
    public $visibilieModaleEdit = false; // Propriété pour contrôler le modal d'édition

    public $newRole = [];
    public $editRole = [];
    public $rolePermissions = [];


    protected $paginationTheme = "bootstrap";

    public function render()
    {

        Carbon::setLocale('fr');
        $searchCriteria = '%' . $this->search . '%';

        return view('livewire.permissions.index', [
            "roles" => Role::where('name', 'like', $searchCriteria)
                ->orderBy('id', 'asc')
                ->paginate(5),
        ])
        ->extends('layouts.app')
        ->section('content');
    }


    // Règles de validation
    protected function rules()
    {
        return [
            'name'  => 'required|string|max:255',
        ];
    }

    public function addRole()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Vérifie si le rôle existe déjà
            if (Role::where('name', $this->name)->where('guard_name', 'web')->exists()) {
                $this->addError('name', 'Ce rôle existe déjà.');
                return;
            }

            Role::create([
                'name' => $this->name,
                'guard_name' => 'web',
            ]);

            $this->reset();
            $this->dispatch("showSuccessMessage", ["message" => "Rôle créé avec succès."]);
            $this->closeModals();

        } catch (\Exception $e) {
            $this->addError('general', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }


    public function goToAddRole()
    {
        $this->reset();
        // Lorsque l'utilisateur clique sur "Ajouter", émettez l'événement
        $this->dispatch('show-add-modal');
    }


    public function goToEditRole($id)
    {
        $this->editRoleId = $id;  // Assurer que l'ID est bien assigné
        $role = Role::find($id);
        $this->dispatch('show-edit-modal');

        if ($role) {
            $this->name = $role->name;
            $this->visibilieModaleEdit = true; // Afficher le modal d'édition
        } else {
            $this->dispatch('showErrorMessage', ['message' => 'Rôle non trouvé.']);
        }
    }



    public function updateRole()
    {
        \Log::info("Tentative de mise à jour du rôle avec l'ID: {$this->editRoleId}");

        $validated = $this->validate(); // Validation

        // Mise à jour du rôle
        $role = Role::find($this->editRoleId);

        if ($role) {
            // Mise à jour du nom du rôle
            $role->update([
                'name' => $this->name,
            ]);

            $this->dispatch("showSuccessMessage", ["message" => "Role mis à jour avec succès."]);
            $this->closeModals(); // Fermer le modal après mise à jour
        } else {
            \Log::error("Rôle avec l'ID {$this->editRoleId} non trouvé.");
            $this->dispatch("showErrorMessage", ["message" => "Rôle non trouvé."]);
        }
    }




    // Réinitialiser le formulaire après l'ajout ou l'édition
    public function resetForm()
    {
        $this->name = '';
        $this->editRoleId = null;
    }

    // Fermer les modals
    public function closeModals()
    {
        $this->visibilieModaleAdd = false;
        $this->visibilieModaleEdit = false;
    }


    public function populateRolePermissions()
    {
        $this->rolePermissions["permissions"] = [];

        // Récupérer le rôle par son ID
        $role = Role::find($this->editRole["id"]);

        // Si le rôle existe, ajouter ses permissions
        if ($role) {
            foreach (Permission::all() as $permission) {
                $this->rolePermissions['permissions'][] = [
                    'permission_id' => $permission->id,
                    'permission_name' => $permission->name,
                    'created_at' => $permission->created_at,  // Ajoute la date de création ici
                    'active' => $role->hasPermissionTo($permission->name),
                ];
            }
        }
    }



    public function selectAllPermissions()
    {
        $selectAll = !empty($this->rolePermissions['permissions']) &&
                    collect($this->rolePermissions['permissions'])->contains('active', false);

        foreach ($this->rolePermissions['permissions'] as $index => $permission) {
            $this->rolePermissions['permissions'][$index]['active'] = $selectAll;
        }
    }




    public function updateRolePermissions()
    {
        $role = Role::find($this->editRole["id"]);

        if ($role) {
            // On récupère les permissions cochées
            $selectedPermissions = collect($this->rolePermissions['permissions'])
                ->filter(fn ($perm) => $perm['active'])
                ->pluck('permission_name')
                ->toArray();

            // On synchronise les permissions avec celles cochées
            $role->syncPermissions($selectedPermissions);

            $this->dispatch('showSuccessMessage', ['message' => 'Permissions mises à jour avec succès.']);
        } else {
            $this->dispatch('showErrorMessage', ['message' => 'Rôle introuvable.']);
        }
    }



    public function goToListRole()
    {
        $this->currentPage = PAGEROLE;
        $this->editRole = [];
        $this->newRole = [];
    }




    public function goToPermission($id)
    {
        $this->editRole = Role::find($id)->toArray();
        $this->populateRolePermissions();
        $this->currentPage = PAGEPERMISSION;
    }


    public function confirmDelete($name, $id)
    {
        $this->dispatch("showConfirmMessage", [
            "message" => [
                "text" => "Vous êtes sur le point de supprimer $name de la liste des roles. Voulez-vous continuer?",
                "title" => "Êtes-vous sûr de continuer?",
                "type" => "warning",
                "data" => [
                    "role_id" => $id
                ]
            ]
        ]);
    }


    public function deleteRole($id)
    {
        Role::destroy($id);
        $this->dispatch("showSuccessMessage", ["message" => "Role supprimé avec succès!"]);
    }
}
