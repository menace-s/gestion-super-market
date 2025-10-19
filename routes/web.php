<?php

use App\Http\Controllers\HomeController;
use App\Livewire\CategorieComp;
use App\Livewire\ClientComp;
use App\Livewire\FournisseurComp;
use App\Livewire\InventaireComp;
use App\Livewire\MouvementStockComp;
use App\Livewire\PermissionRoleComp;
use App\Livewire\ProduitComp;
use App\Livewire\ProfilComp;
use App\Livewire\UtilisateurComp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Groupe principal pour les utilisateurs authentifiés
Route::group([
    "middleware" => ["auth"],
    "as" => "admin."
], function () {

    // --- GESTION DU STOCK ---
    Route::group([
        "prefix" => "stock",
        "as" => "stock."
    ], function () {
        Route::get("/produits", ProduitComp::class)
            ->name("produits.index")
            ->middleware('can:voir produits');

        Route::get("/categories", CategorieComp::class)
            ->name("categories.index")
            ->middleware('can:gérer catégories');

        Route::get("/fournisseurs", FournisseurComp::class)
            ->name("fournisseurs.index")
            ->middleware('can:gérer fournisseurs');
        
        // Note : Ajoute ces permissions dans ton seeder
        Route::get("/inventaires", InventaireComp::class)
            ->name("inventaires.index")
            ->middleware('can:gérer inventaires');

        Route::get("/mouvements", MouvementStockComp::class)
            ->name("mouvements.index")
            ->middleware('can:gérer inventaires');
    });

    // --- GESTION DES CLIENTS ---
    // Note : Ajoute cette permission dans ton seeder
    Route::get("/clients", ClientComp::class)
        ->name("clients.index")
        ->middleware('can:gérer clients');

    // --- ADMINISTRATION ET HABILITATIONS ---
    Route::group([
        "prefix" => "administration",
        "as" => "administration."
    ], function () {
        Route::get("/utilisateurs", UtilisateurComp::class)
            ->name("users.index")
            ->middleware('can:gérer utilisateurs');

        Route::get("/roles-permissions", PermissionRoleComp::class)
            ->name("roles.index")
            ->middleware('can:gérer rôles et permissions');
    });

    // --- PROFIL UTILISATEUR ---
    // Pas besoin de permission spécifique, tout utilisateur connecté peut voir son profil.
    Route::get("/profil", ProfilComp::class)->name("profil");

});