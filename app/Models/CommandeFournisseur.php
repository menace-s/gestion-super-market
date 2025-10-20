<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeFournisseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'fournisseur_id',
        'reference',
        'date_commande',
        'statut',
        'total',
        'notes',
    ];
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_fournisseur_produit')
                    ->withPivot('quantite_commandee', 'prix_unitaire') // Accès aux données de la table pivot
                    ->withTimestamps();
    }
}
