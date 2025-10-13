<?php

namespace App\Livewire;

use App\Models\Categorie;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class CategorieComp extends Component
{
    use WithPagination;

    public $search = '';

    // Propriétés pour les formulaires
    public $newCategorie = [];
    public $editCategorie = [];

    // Propriétés pour la visibilité des modales
    public $visibilieModaleAdd = false;
    public $visibilieModaleEdit = false;

    // AMÉLIORATION : Utilisation de la classe du modèle pour des règles plus robustes
    protected function rules()
    {
        if ($this->visibilieModaleEdit) {
            return [
                'editCategorie.name' => [
                    'required', 
                    'string', 
                    'max:255',
                    Rule::unique(Categorie::class, 'name')->ignore($this->editCategorie['id'])
                ],
                'editCategorie.description' => ['nullable', 'string'],
            ];
        }

        return [
            'newCategorie.name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique(Categorie::class, 'name')
            ],
            'newCategorie.description' => ['nullable', 'string'],
        ];
    }

    // AMÉLIORATION : Réinitialise la pagination lors d'une recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.categorie.index', [
            'categories' => Categorie::where('name', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ])
        ->extends('layouts.app')
        ->section('content');
    }

    // --- Fonctions pour la CRÉATION ---
    public function goToAddCategorie()
    {
        $this->resetErrorBag(); // Vider les anciennes erreurs
        $this->reset('newCategorie');
        $this->visibilieModaleAdd = true;
        $this->dispatch('show-add-modal');
    }

    public function addCategory()
    {
        $validatedData = $this->validate();
        Categorie::create($validatedData['newCategorie']);
        $this->dispatch("showSuccessMessage", ["message" => "Catégorie créée avec succès."]);
        $this->closeModals();
    }

    // --- NOUVEAU : Fonctions pour la MODIFICATION ---
    public function goToEditCategory($id)
    {
        $this->resetErrorBag();
        $this->editCategorie = Categorie::findOrFail($id)->toArray();
        $this->visibilieModaleEdit = true;
        $this->dispatch('show-edit-modal');
    }

    public function updateCategory()
    {
        $validatedData = $this->validate();
        $category = Categorie::findOrFail($this->editCategorie['id']);
        $category->update($validatedData['editCategorie']);
        $this->dispatch("showSuccessMessage", ["message" => "Catégorie mise à jour avec succès."]);
        $this->closeModals();
    }

    // --- NOUVEAU : Fonctions pour la SUPPRESSION SÉCURISÉE ---
    public function confirmDelete($id)
    {
        $categoryName = Categorie::findOrFail($id)->name;
        $this->dispatch("showConfirmMessage", [
            "title" => "Êtes-vous sûr ?",
            "text" => "Vous êtes sur le point de supprimer la catégorie '{$categoryName}'.",
            "icon" => "warning",
            "data" => [
                "category_id" => $id
            ]
        ]);
    }

    #[On('deleteCategory')] // Écoute l'événement JS après confirmation
    public function deleteCategory($id)
    {
        $category = Categorie::findOrFail($id);

        // Point d'attention : voir note plus bas
        if ($category->produits()->count() > 0) {
            $this->dispatch("showSuccessMessage", ["message" => "Erreur : Cette catégorie contient des produits et ne peut pas être supprimée.", "type" => "error"]);
            return;
        }

        $category->delete();
        $this->dispatch("showSuccessMessage", ["message" => "Catégorie supprimée avec succès."]);
    }

    // --- Fonction utilitaire pour fermer les modales ---
    public function closeModals()
    {
        $this->visibilieModaleAdd = false;
        $this->visibilieModaleEdit = false;
        // On s'assure que les données des formulaires sont bien vidées
        $this->reset('newCategorie', 'editCategorie');
    }
}