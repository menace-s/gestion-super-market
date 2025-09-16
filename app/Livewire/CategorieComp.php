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
    public function render()
    {
        return view('livewire.categorie.index',[
            'categories' => Categorie::where('name','like','%'.$this->search.'%')->paginate(10)
        ])
        ->extends('layouts.app')
            ->section('content');
    }
}
