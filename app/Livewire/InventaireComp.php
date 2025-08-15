<?php

namespace App\Livewire;

use Livewire\Component;

class InventaireComp extends Component
{
    public function render()
    {
        return view('livewire.inventaire-comp')
        ->extends('layouts.app')
            ->section('content');
    }
}
