<?php

use App\Livewire\ChatComp;
use App\Livewire\ProfilComp;
use App\Livewire\UtilisateurComp;
use App\Livewire\PermissionRoleComp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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





});
