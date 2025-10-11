<?php

namespace App\Livewire;

// use Carbon\Carbon;
use Livewire\Component;
use App\Models\Produit;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ProduitComp extends Component
{
    use Withpagination;

    public $search ='';
    public $newProduit = [];
    public $editProduit =[];
    public $currentPage = PAGELIST;
    public $viewProduit = null;
    

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
            'newProduit.sku' => 'nullable|string|max:255|unique:produit,sku',
            'newProduit.name' => 'required|string|max:255',
            'newProduit.category_id' => 'nullable|exists:categories,id',
            'newProduit.description' => 'nullable|string',
            'newProduit.prix_achat' => 'required|numeric|min:0',
            'newProduit.prix_vente' => 'required|numeric|min:0',
            'newProduit.quantity' => 'required|integer|min:0',
            'newProduit.min_stock' => 'required|integer|min:0',
            'newProduit.image_path' => 'nullable|string|max:255',
            'newProduit.is_active' => 'boolean',
        ];
    }
    public function render()
    {
        // Carbon::setLocale('fr');
        $searchCriteria = '%' . $this->search . '%';

        return view('livewire.produit.index', [
            'produits' => Produit::where('name', 'like', $searchCriteria)
                ->orWhere('sku', 'like', $searchCriteria)
                ->orWhere('description', 'like', $searchCriteria)
                ->orderBy('id', 'desc')
                ->paginate(10),
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
        $this->newProduit = [];
        $this->currentPage = PAGECREATEFORM;
    }
    public function addProduit(){
        $validatedData = $this->validate();
        Produit::create($validatedData['newProduit']);
        $this->reset('newProduit');
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
