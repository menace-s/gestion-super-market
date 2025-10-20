<?php

namespace App\Livewire;

use App\Models\CommandeFournisseur;
use App\Models\Fournisseur;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\Produit;

class CommandeFournisseurComp extends Component
{
    use WithPagination;

    // --- Propriétés de contrôle et de recherche ---
    public $search = '';
    public $currentPage = PAGELIST;

    // --- Propriétés pour le formulaire de création ---
    public $fournisseur_id;
    public $date_commande;
    public $notes;
    
    // --- Propriétés pour le formulaire d'édition ---
    public $editCommande;
    public $edit_fournisseur_id;
    public $edit_date_commande;
    public $edit_notes;
    public $edit_statut;
    
    // --- Propriétés pour la vue détaillée ---
    public $viewCommande;
    
    public $produitsDuFournisseur = [];
    public $produit_id_a_ajouter;
    public $quantite_a_ajouter = 1;
    
    public function render()
    {
        return view('livewire.commande-fournisseur.index', [
            'commandes' => CommandeFournisseur::with('fournisseur')
                ->where(function (Builder $query) {
                    $searchCriteria = '%' . $this->search . '%';
                    $query->where('reference', 'like', $searchCriteria)
                        ->orWhereHas('fournisseur', function (Builder $subQuery) use ($searchCriteria) {
                            $subQuery->where('name', 'like', $searchCriteria);
                        });
                })
                ->latest()
                ->paginate(10),
            
            'fournisseurs' => Fournisseur::orderBy('name')->get(),
        ])
        ->extends('layouts.app')
        ->section('content');
    }
    
    // --- Méthodes de navigation ---
    public function goToListeCommandes()
    {
        $this->reset('editCommande', 'viewCommande');
    
        // On nettoie aussi les erreurs de validation des formulaires
        $this->resetErrorBag();

        // On retourne à la liste
        $this->currentPage = PAGELIST;
    }

    public function goToCreateCommande()
    {
        $this->resetErrorBag();
        $this->reset(['fournisseur_id', 'date_commande', 'notes']);
        $this->currentPage = PAGECREATEFORM;
    }

    // --- Méthode de création ---
    public function store()
    {
        $validatedData = $this->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_commande' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        
        $validatedData['statut'] = 'brouillon';
        $validatedData['reference'] = 'CMD-' . now()->year . '-' . Str::upper(Str::random(6));
        $validatedData['total'] = 0;

        $commande = CommandeFournisseur::create($validatedData);

        $this->dispatch("showSuccessMessage", ["message" => "Commande créée avec succès. Vous pouvez maintenant y ajouter des produits."]);
        
        $this->goToEditCommande($commande->id);
    }
    
    // --- Méthode d'édition ---
    public function goToEditCommande($id)
    {
        $this->resetErrorBag();
        $commande = CommandeFournisseur::with(['fournisseur', 'produits'])->findOrFail($id);
        $this->editCommande = $commande;

        // Remplir les champs d'édition
        $this->edit_fournisseur_id = $commande->fournisseur_id;
        $this->edit_date_commande = $commande->date_commande;
        $this->edit_notes = $commande->notes;
        $this->edit_statut = $commande->statut;

        // Charger les produits du fournisseur avec le pivot prix_fournisseur
        if ($commande->fournisseur) {
            $this->produitsDuFournisseur = $commande->fournisseur->produits()
                ->withPivot('prix_fournisseur')
                ->get();
        }
        
        $this->currentPage = PAGEEDITFORM;
    }
    
    // --- Méthode de mise à jour des informations générales ---
    public function updateCommande()
    {
        $validatedData = $this->validate([
            'edit_fournisseur_id' => 'required|exists:fournisseurs,id',
            'edit_date_commande' => 'required|date',
            'edit_statut' => 'required|in:brouillon,envoyee,receptionnee,annulee',
            'edit_notes' => 'nullable|string',
        ]);

        // Vérifier si le fournisseur a changé
        $fournisseurChange = $this->editCommande->fournisseur_id != $this->edit_fournisseur_id;

        // Mise à jour de la commande
        $this->editCommande->update([
            'fournisseur_id' => $this->edit_fournisseur_id,
            'date_commande' => $this->edit_date_commande,
            'statut' => $this->edit_statut,
            'notes' => $this->edit_notes,
        ]);

        // Si le fournisseur a changé, supprimer tous les produits
        if ($fournisseurChange) {
            $this->editCommande->produits()->detach();
            $this->editCommande->update(['total' => 0]);
            $this->dispatch("showWarningMessage", ["message" => "Le fournisseur a été changé. Tous les produits ont été retirés de la commande."]);
        } else {
            $this->dispatch("showSuccessMessage", ["message" => "Commande mise à jour avec succès."]);
        }

        // Recharger les données
        $this->editCommande = $this->editCommande->fresh()->load(['fournisseur', 'produits']);
        
        // Recharger les produits du fournisseur
        if ($this->editCommande->fournisseur) {
            $this->produitsDuFournisseur = $this->editCommande->fournisseur->produits()
                ->withPivot('prix_fournisseur')
                ->get();
        }
    }
    
    // --- Gestion des produits ---
    public function addProduitToCommande()
    {
        $this->validate([
            'produit_id_a_ajouter' => 'required|exists:produits,id',
            'quantite_a_ajouter' => 'required|integer|min:1',
        ]);

        // Vérifier si le produit est déjà dans la commande
        if ($this->editCommande->produits()->where('produit_id', $this->produit_id_a_ajouter)->exists()) {
            $this->addError('produit_id_a_ajouter', 'Ce produit est déjà dans la commande.');
            return;
        }

        $fournisseur = Fournisseur::find($this->editCommande->fournisseur_id);
        $produitAvecPivot = $fournisseur->produits()
            ->withPivot('prix_fournisseur')
            ->find($this->produit_id_a_ajouter);

        if (!$produitAvecPivot || is_null($produitAvecPivot->pivot->prix_fournisseur)) {
            $this->addError('produit_id_a_ajouter', 'Impossible de trouver le prix pour ce produit.');
            return;
        }

        $prixFournisseur = $produitAvecPivot->pivot->prix_fournisseur;

        $this->editCommande->produits()->attach($this->produit_id_a_ajouter, [
            'quantite_commandee' => $this->quantite_a_ajouter,
            'prix_unitaire' => $prixFournisseur,
        ]);
        
        $this->editCommande = $this->editCommande->fresh()->load('produits');
        $this->recalculateTotal();
        $this->reset(['produit_id_a_ajouter', 'quantite_a_ajouter']);
        
        $this->dispatch("showSuccessMessage", ["message" => "Produit ajouté avec succès."]);
    }
    
    public function updateQuantiteProduit($produitId, $nouvelleQuantite)
    {
        if ($nouvelleQuantite < 1) {
            $this->dispatch("showErrorMessage", ["message" => "La quantité doit être au moins 1."]);
            return;
        }

        $this->editCommande->produits()->updateExistingPivot($produitId, [
            'quantite_commandee' => $nouvelleQuantite
        ]);
        
        $this->editCommande = $this->editCommande->fresh()->load('produits');
        $this->recalculateTotal();
        
        $this->dispatch("showSuccessMessage", ["message" => "Quantité mise à jour."]);
    }
    
    public function removeProduitFromCommande($produitId)
    {
        $this->editCommande->produits()->detach($produitId);
        $this->editCommande = $this->editCommande->fresh()->load('produits');
        $this->recalculateTotal();
        
        $this->dispatch("showSuccessMessage", ["message" => "Produit retiré de la commande."]);
    }
    
    protected function recalculateTotal()
    {
        $total = $this->editCommande->produits->sum(function ($produit) {
            return $produit->pivot->quantite_commandee * $produit->pivot->prix_unitaire;
        });
        
        $this->editCommande->total = $total;
        $this->editCommande->save();
    }
    
    // --- Méthode de suppression ---
    public function deleteCommande($id)
{
    $commande = CommandeFournisseur::findOrFail($id);
    
    // Supprimer les produits associés (pivot)
    $commande->produits()->detach();
    
    // Supprimer la commande
    $commande->delete();
    
    // Envoyer le message de succès
    $this->dispatch("showSuccessMessage", ["message" => "Commande supprimée avec succès."]);
    
    // NOUVEAU : Revenir à la liste des commandes
    $this->goToListeCommandes();
}
    public function goToViewCommande($id)
    {
        // On s'assure de vider les anciennes erreurs
        $this->resetErrorBag();

        // On charge la commande avec ses relations pour un affichage complet
        $commande = CommandeFournisseur::with(['fournisseur', 'produits'])->findOrFail($id);
        
        // On stocke l'objet commande dans la propriété dédiée à la vue
        $this->viewCommande = $commande;

        // On change l'état de la page pour afficher la vue des détails
        $this->currentPage = PAGEVIEW;
    }
}