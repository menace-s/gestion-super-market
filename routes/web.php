<?php

use App\Livewire\ChatComp;
use App\Livewire\ProfilComp;
use App\Livewire\UtilisateurComp;
use App\Livewire\PermissionRoleComp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\CategorieComp;
use App\Livewire\ClientComp;
use App\Livewire\FournisseurComp;
use App\Livewire\InventaireComp;
use App\Livewire\MouvementStockComp;
use App\Livewire\ProduitComp;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('welcome');


// Le groupe des routes relatives aux administrateurs
Route::group([
    "middleware" => ["auth"],
    "as" => "admin."
], function(){



    Route::group([
        "prefix" => "habilitations",
        "as" => "habilitations."
    ], function(){
        Route::get("/utilisateurs", UtilisateurComp::class)
            ->name("users.index")
            ->middleware('can:utilisateurs');
    });


    Route::get("/profil", ProfilComp::class)
            ->name("profil")
            ->middleware('can:profil');



    Route::get("/rôle-permission", PermissionRoleComp::class)
            ->name("rôle-permission")
            ->middleware('can:Permission & rôle');


    Route::get("/produit", ProduitComp::class)
            ->name("produit")
            ->middleware('can:Permission & rôle');


    Route::get("/categorie", CategorieComp::class)
                ->name("categorie")
                ->middleware('can:Permission & rôle');

    Route::get("/inventaire", InventaireComp::class)
            ->name("inventaire")
            ->middleware('can:Permission & rôle');

    Route::get("/mouvement_stock", MouvementStockComp::class)
            ->name("mouvement_stock")
            ->middleware('can:Permission & rôle');

    Route::get("/fournisseur", FournisseurComp::class)
            ->name("fournisseur")
            ->middleware('can:Permission & rôle');

    Route::get("/client", ClientComp::class)
            ->name("client")
            ->middleware('can:Permission & rôle');


});
