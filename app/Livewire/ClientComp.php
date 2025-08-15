<?php

namespace App\Livewire;

use Livewire\Component;

class ClientComp extends Component
{
    public function render()
    {
        return view('livewire.client-comp')
        ->extends('layouts.app')
            ->section('content');
    }
}
