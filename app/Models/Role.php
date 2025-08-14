<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasFactory, HasRoles; // Utiliser le trait HasRoles pour gérer les rôles

    protected $fillable = ['name'];

    public $timestamps = false; // Désactiver les timestamps

    /**
     * Obtenir les utilisateurs qui ont ce rôle.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Obtenir les permissions associées à ce rôle.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    
}