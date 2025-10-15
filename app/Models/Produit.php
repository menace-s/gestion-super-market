<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Categorie;
class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'description',
        'prix_achat',
        'prix_vente',
        'quantity',
        'min_stock',
        'image_path',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_produit')
                    ->withPivot('prix_fournisseur', 'delai_livraison_jours')
                    ->withTimestamps();
    }
}
