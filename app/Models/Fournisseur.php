<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;


    protected $table = 'fournisseurs';


    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'adress',
    ];
    public function commandes()
    {
        return $this->hasMany(CommandeFournisseur::class);
    }

    /**
     * Récupère tous les produits que ce fournisseur peut fournir.
     * (Relation N-M, déjà définie)
     */
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'fournisseur_produit')
                    ->withPivot('prix_fournisseur', 'delai_livraison_jours')
                    ->withTimestamps();
    }


    protected $casts = [
        'name' => 'string',
        'contact_name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'adress' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
