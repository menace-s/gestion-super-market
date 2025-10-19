<?php

namespace App\Livewire;

// use Carbon\Carbon;
use Livewire\Component;
use App\Models\Produit;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\Categorie;
use Illuminate\Support\Facades\Storage;
use App\Models\Fournisseur;
use App\Events\ProductStockUpdated;
use Illuminate\Database\Eloquent\Builder;

class ProduitComp extends Component
{
    use Withpagination;
    use WithFileUploads;

    public $search ='';
    public $newProduit = [];
    public $editProduit =[];
    public $currentPage = PAGELIST;
    public $viewProduit = null;
    public $image;
    public $newImage;

    // Propriétés pour le formulaire d'ajout de fournisseur
    public $selectedFournisseur;
    public $fournisseurPrix;
    public $fournisseurDelai;
    public $showLowStockOnly = false;
    
    public function getAllFournisseursProperty()
    {
        return Fournisseur::orderBy('name')->get();
    }
    public function rules(){
    if($this->currentPage == PAGEEDITFORM){
        return [
            'editProduit.sku' => ['required', 'string', Rule::unique(Produit::class, 'sku')->ignore($this->editProduit['id'])],
            'editProduit.name' => ['required', 'string', 'max:255'],
            'editProduit.category_id' => ['nullable', 'exists:categories,id'],
            'editProduit.description' => ['nullable', 'string'],
            'editProduit.prix_achat' => ['required', 'numeric', 'min:0'],
            'editProduit.prix_vente' => ['required', 'numeric', 'min:0'],
            'editProduit.quantity' => ['required', 'integer', 'min:0'],
            'editProduit.min_stock' => ['required', 'integer', 'min:0'],
            'editProduit.is_active' => ['boolean'],
            'newImage' => ['nullable', 'image', 'max:2048'], // La règle est ajoutée
        ];
    }
    
    // On passe tout en syntaxe "array" pour la cohérence
    return [
        'newProduit.sku' => ['nullable', 'string', 'max:255', Rule::unique(Produit::class, 'sku')],
        'newProduit.name' => ['required', 'string', 'max:255'],
        'newProduit.category_id' => ['nullable', 'exists:categories,id'],
        'newProduit.description' => ['nullable', 'string'],
        'newProduit.prix_achat' => ['required', 'numeric', 'min:0'],
        'newProduit.prix_vente' => ['required', 'numeric', 'min:0'],
        'newProduit.quantity' => ['required', 'integer', 'min:0'],
        'newProduit.min_stock' => ['required', 'integer', 'min:0'],
        'newProduit.is_active' => ['boolean'],
        'image' => ['nullable', 'image', 'max:2048'],
    ];
    }
    public function render()
    {
        // Carbon::setLocale('fr');
        // Note : $categories est maintenant géré par une propriété calculée, c'est plus propre
        $categories = Categorie::orderBy('name')->get();

        return view('livewire.produit.index', [
            'produits' => Produit::with('category')
                // On groupe les conditions de recherche pour une requête propre et sans bug
                ->where(function (Builder $query) {
                    $searchCriteria = '%' . $this->search . '%';
                    $query->where('name', 'like', $searchCriteria)
                        ->orWhere('sku', 'like', $searchCriteria)
                        ->orWhere('description', 'like', $searchCriteria);
                })
                // On ajoute notre filtre conditionnel pour le stock faible
                ->when($this->showLowStockOnly, function (Builder $query) {
                    $query->whereColumn('quantity', '<=', 'min_stock');
                })
                ->latest() // 'latest()' est un alias plus lisible pour orderBy('created_at', 'desc')
                ->paginate(10),
                
            // 'categories' est déjà disponible via la propriété calculée,
            // mais si tu ne l'as pas encore fait, tu peux laisser la ligne ci-dessous :
            'categories' => $categories,
        ])
        ->extends('layouts.app')
        ->section('content');
    }
    public function showProduit($id){
        $this->viewProduit = Produit::with(['category', 'fournisseurs'])->findOrFail($id);
        // dd($this->viewProduit);
        $this->currentPage = PAGEVIEW;
    } 
    public function goToListeProduit(){
        $this->currentPage = PAGELIST;
    }
    public function goToAddProduit(){
        $this->resetErrorBag();
        $this->newProduit = [];
        $this->image = null; 
        
        
        $this->newProduit['is_active'] = true; 
        $this->currentPage = PAGECREATEFORM;
    }
    public function addProduit()
    {
        // 1. On valide les données du formulaire, y compris notre nouvelle règle pour l'image.
        $validatedData = $this->validate();
        $produitData = $validatedData['newProduit'];

        // 2. On gère l'upload de l'image SI elle existe.
        if ($this->image) {
            // On stocke l'image dans 'storage/app/public/produits'
            // et on récupère son chemin.
            $path = $this->image->store('produits', 'public');
            
            // 3. On ajoute le chemin de l'image aux données à sauvegarder.
            $produitData['image_path'] = $path;
        }

        // 4. On crée le produit avec toutes les données.
        Produit::create($produitData);

        // 5. On réinitialise les champs et on affiche le message de succès.
        $this->reset('newProduit', 'image');
        $this->dispatch('showSuccessMessage', ['message' => 'Produit ajouté avec succès!']);
        $this->goToListeProduit();
    }
    public function goToEditProduit($id){

        $this->resetErrorBag();
        $produit = Produit::with('fournisseurs')->findOrFail($id);
        $this->editProduit = $produit->toArray();
        $this->newImage = null; // On réinitialise le champ de la nouvelle image
        $this->reset('selectedFournisseur', 'fournisseurPrix', 'fournisseurDelai');
        $this->currentPage = PAGEEDITFORM;
    }
    public function updateProduit()
    {
        // 1. On valide les données avec les règles d'édition.
        $validatedData = $this->validate();
        // dd("validated data =",$validatedData);
        $produitData = $validatedData['editProduit'];
        // dd($produitData);

        // 2. On gère la nouvelle image SI elle a été uploadée.
        if ($this->newImage) {
            // a. On sauvegarde la nouvelle image.
            $path = $this->newImage->store('produits', 'public');
            $produitData['image_path'] = $path;

            // b. On supprime l'ancienne image pour ne pas laisser de fichiers orphelins.
            if (!empty($this->editProduit['image_path'])) {
                Storage::disk('public')->delete($this->editProduit['image_path']);
            }
        }

        // 3. On récupère le produit et on le met à jour.
        $produit = Produit::find($this->editProduit['id']);
        $produit->update($produitData);
        // NOUVEAU : On déclenche l'événement de mise à jour du stock
        ProductStockUpdated::dispatch($produit);
        $this->dispatch('notification-received');

        // 4. On affiche le message de succès et on retourne à la liste.
        $this->dispatch("showSuccessMessage", ["message" => "Produit mis à jour avec succès!"]);
        $this->goToListeProduit();
    }
    public function confirmDelete($name, $id)
    {
        $this->dispatch("showConfirmMessage", [
            "message" => [
                "text" => "Vous êtes sur le point de supprimer  $name de la liste des produits . Voulez-vous continuer?",
                "title" => "Êtes-vous sûr de continuer?",
                "type" => "warning",
                "data" => [
                    "Produit_id" => $id
                ]
            ]
        ]);
    }
    public function deleteProduit($id){
        Produit::destroy($id);
        $this->dispatch("showSuccessMessage", ["message" => "Produit supprimé avec succès!"]);
    }

    // NOUVELLE MÉTHODE : Pour associer un fournisseur
    public function addFournisseur()
    {
        $this->validate([
            'selectedFournisseur' => 'required|exists:fournisseurs,id',
            'fournisseurPrix' => 'required|numeric|min:0',
            'fournisseurDelai' => 'nullable|integer|min:0',
        ]);

        $produit = Produit::find($this->editProduit['id']);
        
        // La méthode magique pour attacher, avec les données du pivot !
        $produit->fournisseurs()->attach($this->selectedFournisseur, [
            'prix_fournisseur' => $this->fournisseurPrix,
            'delai_livraison_jours' => $this->fournisseurDelai,
        ]);

        // On rafraîchit les données et on vide les champs
        $this->editProduit = $produit->fresh()->load('fournisseurs')->toArray();
        $this->reset('selectedFournisseur', 'fournisseurPrix', 'fournisseurDelai');
        $this->dispatch("showSuccessMessage", ["message" => "Fournisseur ajouté au produit."]);
    }

    // NOUVELLE MÉTHODE : Pour dissocier un fournisseur
    public function detachFournisseur($fournisseurId)
    {
        $produit = Produit::find($this->editProduit['id']);
        $produit->fournisseurs()->detach($fournisseurId);

        // On rafraîchit les données
        $this->editProduit = $produit->fresh()->load('fournisseurs')->toArray();
        $this->dispatch("showSuccessMessage", ["message" => "Fournisseur retiré du produit."]);
    }
    public function updatingShowLowStockOnly()
    {
        $this->resetPage();
    }
}