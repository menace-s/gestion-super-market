<?php

namespace App\Livewire;

use Livewire\Component;

class CategorieComp extends Component
{
    public function render()
    {
        return view('livewire.categorie.index')
        ->extends('layouts.app')
            ->section('content');
    }
}
