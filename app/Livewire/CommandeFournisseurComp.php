<?php

namespace App\Livewire;

use App\Models\CommandeFournisseur;
use App\Models\Fournisseur;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class CommandeFournisseurComp extends Component
{
    use WithPagination;

    public $search = '';
    public $currentpage=PAGELIST;
    public $fournisseur_id;
    public $date_commande;

    public function render()
    {
        return view('livewire.commande-fournisseur.index', [ // Le nom de la vue a été corrigé
            'commandes' => CommandeFournisseur::with('fournisseur')
                ->where(function(Builder $query) {
                    $searchCriteria = '%' . $this->search . '%';
                    
                    // Recherche sur la référence de la commande
                    $query->where('reference', 'like', $searchCriteria)
                        
                        // NOUVEAU : Recherche sur le nom du fournisseur via la relation
                        ->orWhereHas('fournisseur', function (Builder $subQuery) use ($searchCriteria) {
                            $subQuery->where('name', 'like', $searchCriteria);
                        });
                })
                ->latest()
                ->paginate(10),
                
            'fournisseurs' => Fournisseur::orderBy('name')->get(), // 'orderBy' est une bonne pratique pour les listes déroulantes
        ])
        ->extends('layouts.app')
        ->section('content');
    }
}
