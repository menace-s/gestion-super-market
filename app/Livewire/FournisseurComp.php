<?php

namespace App\Livewire;

use Livewire\Component;

class FournisseurComp extends Component
{
    public function render()
    {
        return view('livewire.fournisseur-comp')
        ->extends('layouts.app')
            ->section('content');
    }
}
