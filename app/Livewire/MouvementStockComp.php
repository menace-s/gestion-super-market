<?php

namespace App\Livewire;

use Livewire\Component;

class MouvementStockComp extends Component
{
    public function render()
    {
        return view('livewire.mouvement-stock-comp')
        ->extends('layouts.app')
            ->section('content');
    }
}
