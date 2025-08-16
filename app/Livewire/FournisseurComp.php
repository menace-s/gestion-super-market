<?php

namespace App\Livewire;

use Livewire\Component;

class FournisseurComp extends Component
{
    public function render()
    {
        return view('livewire.fournisseur.index')
        ->extends('layouts.app')
            ->section('content');
    }
}
