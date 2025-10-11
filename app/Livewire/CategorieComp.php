<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categorie;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class CategorieComp extends Component
{
    use Withpagination;

    public $search ='';
    public $newCategorie = [];
    public $editCategorie =[];
    public $currentPage = PAGELIST;
    public $viewCategorie = null;

    public $visibilieModaleAdd = false;
    public $visibilieModaleEdit = false;


    
    protected function rules(){
        if($this->currentPage == PAGEEDITFORM){
            return [
                'editCategorie.name' => ['required', 'string', Rule::unique('categories', 'name')->ignore($this->editCategorie['id'])],
                'editCategorie.description' => ['nullable', 'string'],
            ];
        }
        return [
            'newCategorie.name' => 'required|string|max:255|unique:categories,name',
            'newCategorie.description' => 'nullable|string',
        ];
    }
    public function render()
    {
        return view('livewire.categorie.index',[
            'categories' => Categorie::where('name','like','%'.$this->search.'%')->paginate(10)
        ])
        ->extends('layouts.app')
            ->section('content');
    }
    public function goToAddCategorie(){
        // dd('ok');
        $this->reset('newCategorie');
        $this->visibilieModaleAdd = true;
        $this->dispatch('show-add-modal');
    }
    public function addCategory(){
        $validatedData = $this->validate();
        Categorie::create($validatedData['newCategorie']);
        $this->dispatch("showSuccessMessage", ["message" => "Catégorie créé avec succès."]);
        $this->closeModals();
    }
    // Fermer les modals
    public function closeModals()
    {
        $this->visibilieModaleAdd = false;
        $this->visibilieModaleEdit = false;
    }
}
