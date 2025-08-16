<?php

namespace App\Livewire;

use Livewire\Component;

class ProduitComp extends Component
{
    public function render()
    {
        return view('livewire.produit.index')
        ->extends('layouts.app')
            ->section('content');
    }
}
