<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'adress',
    ];
}
