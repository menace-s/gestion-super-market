<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Role; // Importer le modèle Role
use Livewire\Component;
use Livewire\WithPagination;

class UtilisateurComp extends Component
{
    use WithPagination;

    public $name,
           $email,
           $phone,
           $password,
           $search = "",
           $editUserId = null,
           $role_id; // Ajout de la propriété role_id

    public $visibilieModaleAdd = false;
    public $visibilieModaleEdit = false;

    public $newUser = [];
    public $roles; // Ajout de la propriété pour les rôles
    public $editUser = [];

    protected $paginationTheme = "bootstrap";

    // Règles de validation
    protected function rules()
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->editUserId,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $this->editUserId,
            'role_id' => 'nullable|exists:roles,id', // Validation du role_id
        ];
    }

    public function mount()
    {
        // Charger tous les rôles disponibles
        $this->roles = Role::all(); // Chargement des rôles
    }

    public function render()
    {
        Carbon::setLocale('fr');
        $searchCriteria = '%' . $this->search . '%';

        return view('livewire.habilitations.index', [
            "users" => User::where('name', 'like', $searchCriteria)
                ->orWhere('phone', 'like', $searchCriteria)
                ->orWhere('email', 'like', $searchCriteria)
                ->orderBy('id', 'asc')
                ->paginate(7),
            "roles" => $this->roles, // Passer les rôles à la vue
        ])
        ->extends("layouts.app")
        ->section("content");
    }

    public function addUser()
    {
        $validated = $this->validate();

        try {
            // Créer l'utilisateur sans le champ role_id
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'phone'    => $this->phone,
                'password' => bcrypt($this->password ?? 'password123'), // facultatif ou généré
            ]);

            // Attribuer le rôle via Spatie
            $user->assignRole(intval($this->role_id));

            $this->resetForm();
            $this->dispatch("showSuccessMessage", ["message" => "Utilisateur créé avec succès."]);
            $this->closeModals();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                if (str_contains($e->getMessage(), 'users_email_unique')) {
                    $this->addError('email', 'Cet email est déjà utilisé.');
                } elseif (str_contains($e->getMessage(), 'users_phone_unique')) {
                    $this->addError('phone', 'Ce numéro de téléphone est déjà utilisé.');
                } else {
                    $this->addError('general', 'Une erreur est survenue lors de l\'ajout de l\'utilisateur.');
                }
            }
        }
    }


    public function goToAddUser()
    {
        $this->resetForm(); // Réinitialise uniquement les champs du formulaire
        $this->roles = Role::all(); // Recharge les rôles
        $this->visibilieModaleAdd = true; // Active le modal côté Livewire si tu l'utilises dans une condition `@if`
        $this->dispatch('show-add-modal'); // Déclenche l'événement JS pour afficher le modal
    }


    public function goToEditUser($id)
    {
        $user = User::find($id);
        $this->dispatch('show-edit-modal');

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->editUserId = $user->id;

            // Charger le premier rôle de l'utilisateur (si existant)
            $role = $user->roles()->first();
            $this->role_id = $role ? $role->id : null;

            $this->visibilieModaleEdit = true;
        } else {
            $this->dispatch('showErrorMessage', ['message' => 'Utilisateur non trouvé.']);
        }
    }


    public function toggleActivation($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->is_active = !$user->is_active;
            $user->save();

            $this->dispatch('showSuccessMessage', [
                'message' => "L'utilisateur a été " . ($user->is_active ? 'activé' : 'désactivé') . " avec succès."
            ]);
        }
    }



    public function updateUser()
    {
        $validated = $this->validate();

        // Mise à jour de l'utilisateur
        $user = User::find($this->editUserId);

        if ($user) {
            $user->update([
                'name'  => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role_id' => $this->role_id, // Mettre à jour le rôle de l'utilisateur
            ]);

            $this->dispatch("showSuccessMessage", ["message" => "Utilisateur mis à jour avec succès."]);
            $this->closeModals();
        }
    }

    // Réinitialiser le formulaire après l'ajout ou l'édition
    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role_id = ''; // Réinitialiser le role_id
        $this->editUserId = null;
    }

    // Fermer les modals
    public function closeModals()
    {
        $this->visibilieModaleAdd = false;
        $this->visibilieModaleEdit = false;
    }

    public function confirmDelete($name, $id)
    {
        $this->dispatch("showConfirmMessage", [
            "message" => [
                "text" => "Vous êtes sur le point de supprimer $name de la liste des utilisateurs. Voulez-vous continuer ?",
                "title" => "Êtes-vous sûr de continuer ?",
                "type" => "warning",
                "data" => [
                    "user_id" => $id
                ]
            ]
        ]);
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        $this->dispatch("showSuccessMessage", ["message" => "Utilisateur supprimé avec succès!"]);
    }
}
