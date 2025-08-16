<?php

namespace App\Livewire;

use Livewire\Component;

class MouvementStockComp extends Component
{
    public function render()
    {
        return view('livewire.mouvement_stock.index')
        ->extends('layouts.app')
            ->section('content');
    }
}
