<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ClientComp extends Component
{
    use Withpagination;
    public $search ='';
    public $newClient = [];
    public $editClient =[];
    public $currentPage = PAGELIST;
    public $viewClient = null;

    public function rules(){
        if($this->currentPage == PAGEEDITFORM){
            return [
                'editClient.name' =>['required', 'string', 'max:255'],
                'editClient.contact_name' => ['nullable','string'],
                'editClient.email' => ['required','email',Rule::unique('Client','email')->ignore($this->editClient['id'])],
                'editClient.phone' => ['nullable','string'],
                'editClient.adress' => ['nullable','text'],
            ];
        }
        return [
                'newClient.name' =>['required', 'string', 'max:255'],
                'newClient.contact_name' => ['nullable','string'],
                'newClient.email' => ['required','email',Rule::unique('Client','email')],
                'newClient.phone' => ['nullable','string'],
                'newClient.adress' => ['nullable','text'],
        ];
    }
    public function render()
    {
        return view('livewire.client.index')
        ->extends('layouts.app')
            ->section('content');
    }
    public function goToViewClient($id){
        $this->viewClient=Client::findOrfail($id);
        $this->currentPage = PAGEVIEW;
    } 
    public function goToListeClient(){
        $this->currentPage = PAGELIST;
    }
    public function goToAddClient(){
        $this->newClient = [];
        $this->currentPage = PAGECREATEFORM;
    }
    public function addClient(){
        $validatedData = $this->validate();
        Client::create($validatedData['newClient']);
        $this->reset('newClient');
        $this->dispatch('showSuccessMessage', ['message' => 'Client ajouté avec succès!']);
        $this->goToListeClient();
    }
    public function goToEditClient($id){
        $this->editClient = Client::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }
    public function updateClient(){
        $validatedData = $this->validate();
        $Client = Client::find($this->editClient['id']);
        $Client->update($validatedData['editClient']);
        $this->dispatch("showSuccessMessage", ["message" => "Client mis à jour avec succès!"]);
        $this->goToListeClient();
    }
    public function confirmDelete($name, $id)
    {
        $this->dispatch("showConfirmMessage", [
            "message" => [
                "text" => "Vous êtes sur le point de supprimer  $name de la liste des Clients. Voulez-vous continuer?",
                "title" => "Êtes-vous sûr de continuer?",
                "type" => "warning",
                "data" => [
                    "Client_id" => $id
                ]
            ]
        ]);
    }
    public function deleteClient($id){
        Client::destroy($id);
        $this->dispatch("showSuccessMessage", ["message" => "Client supprimé avec succès!"]);
    }
}
