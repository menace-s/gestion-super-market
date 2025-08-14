<?php

// app/Models/Permission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;  // Désactiver les timestamps
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(Permission::class, "user_permission", "permission_id", "user_id");
    }
}