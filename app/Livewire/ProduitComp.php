<?php

namespace App\Livewire;

// use Carbon\Carbon;
use Livewire\Component;
use App\Models\Produit;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\Categorie;

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
    

    public function rules(){
        if($this->currentPage == PAGEEDITFORM){
            return [
                'editProduit.sku' => ['required', 'string', Rule::unique('produit', 'sku')->ignore($this->editProduit['id'])],
                'editProduit.name' => ['required', 'string', 'max:255'],
                'editProduit.category_id' => ['nullable', 'exists:categories,id'],
                'editProduit.description' => ['nullable', 'string'],
                'editProduit.prix_achat' => ['required', 'numeric', 'min:0'],
                'editProduit.prix_vente' => ['required', 'numeric', 'min:0'],
                'editProduit.quantity' => ['required', 'integer', 'min:0'],
                'editProduit.min_stock' => ['required', 'integer', 'min:0'],
                'editProduit.is_active' => ['boolean'],
            ];
        }
        return [
            'newProduit.sku' => 'nullable|string|max:255|unique:produits,sku',
            'newProduit.name' => 'required|string|max:255',
            'newProduit.category_id' => 'nullable|exists:categories,id',
            'newProduit.description' => 'nullable|string',
            'newProduit.prix_achat' => 'required|numeric|min:0',
            'newProduit.prix_vente' => 'required|numeric|min:0',
            'newProduit.quantity' => 'required|integer|min:0',
            'newProduit.min_stock' => 'required|integer|min:0',
            // 'newProduit.image_path' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'newProduit.is_active' => 'boolean',
        ];
    }
    public function render()
    {
        // Carbon::setLocale('fr');
        $searchCriteria = '%' . $this->search . '%';
        $categories = Categorie::orderBy('name')->get();

        return view('livewire.produit.index', [
            'produits' => Produit::where('name', 'like', $searchCriteria)
                ->orWhere('sku', 'like', $searchCriteria)
                ->orWhere('description', 'like', $searchCriteria)
                ->orderBy('id', 'desc')
                ->paginate(10),
            'categories' => $categories,
        ])
        ->extends('layouts.app')
            ->section('content');
    }
    public function goToViewProduit($id){
        $this->viewProduit=Produit::findOrfail($id);
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
        $this->editProduit = Produit::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }
    public function updateProduit(){
        $validatedData = $this->validate();
        $produit = Produit::find($this->editProduit['id']);
        $produit->update($validatedData['editProduit']);
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
}
