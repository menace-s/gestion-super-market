<?php

namespace App\Livewire;

use Livewire\Component;

class InventaireComp extends Component
{
    public function render()
    {
        return view('livewire.inventaire.index')
        ->extends('layouts.app')
            ->section('content');
    }
}
