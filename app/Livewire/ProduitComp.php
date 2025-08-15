<?php

namespace App\Livewire;

use Livewire\Component;

class ProduitComp extends Component
{
    public function render()
    {
        return view('livewire.produit-comp')
        ->extends('layouts.app')
            ->section('content');
    }
}
