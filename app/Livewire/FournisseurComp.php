<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Fournisseur;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class FournisseurComp extends Component
{
    use Withpagination;
    public $search ='';
    public $newFournisseur = [];
    public $editFournisseur =[];
    public $currentPage = PAGELIST;
    public $viewFournisseur = null;

    public function rules(){
        if($this->currentPage == PAGEEDITFORM){
            return [
                'editFournisseur.name' =>['required', 'string', 'max:255'],
                'editFournisseur.contact_name' => ['nullable','string'],
                'editFournisseur.email' => ['required','email',Rule::unique('fournisseur','email')->ignore($this->editFournisseur['id'])],
                'editFournisseur.phone' => ['nullable','string'],
                'editFournisseur.adress' => ['nullable','text'],
            ];
        }
        return [
                'newFournisseur.name' =>['required', 'string', 'max:255'],
                'newFournisseur.contact_name' => ['nullable','string'],
                'newFournisseur.email' => ['required','email',Rule::unique('fournisseur','email')],
                'newFournisseur.phone' => ['nullable','string'],
                'newFournisseur.adress' => ['nullable','text'],
        ];
    }

    public function render()
    {
        return view('livewire.fournisseur.index')
        ->extends('layouts.app')
            ->section('content');
    }
    public function goToViewFournisseur($id){
        $this->viewFournisseur=Fournisseur::findOrfail($id);
        $this->currentPage = PAGEVIEW;
    } 
    public function goToListeFournisseur(){
        $this->currentPage = PAGELIST;
    }
    public function goToAddFournisseur(){
        $this->newFournisseur = [];
        $this->currentPage = PAGECREATEFORM;
    }
    public function addFournisseur(){
        $validatedData = $this->validate();
        Fournisseur::create($validatedData['newFournisseur']);
        $this->reset('newFournisseur');
        $this->dispatch('showSuccessMessage', ['message' => 'Fournisseur ajouté avec succès!']);
        $this->goToListeFournisseur();
    }
    public function goToEditFournisseur($id){
        $this->editFournisseur = Fournisseur::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }
    public function updateFournisseur(){
        $validatedData = $this->validate();
        $Fournisseur = Fournisseur::find($this->editFournisseur['id']);
        $Fournisseur->update($validatedData['editFournisseur']);
        $this->dispatch("showSuccessMessage", ["message" => "Fournisseur mis à jour avec succès!"]);
        $this->goToListeFournisseur();
    }
    public function confirmDelete($name, $id)
    {
        $this->dispatch("showConfirmMessage", [
            "message" => [
                "text" => "Vous êtes sur le point de supprimer  $name de la liste des fournisseurs. Voulez-vous continuer?",
                "title" => "Êtes-vous sûr de continuer?",
                "type" => "warning",
                "data" => [
                    "Fournisseur_id" => $id
                ]
            ]
        ]);
    }
    public function deleteFournisseur($id){
        Fournisseur::destroy($id);
        $this->dispatch("showSuccessMessage", ["message" => "Fournisseur supprimé avec succès!"]);
    }
}
