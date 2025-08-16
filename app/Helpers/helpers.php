<?php

use App\Models\Recharge;
use App\Models\Transaction;
use App\Models\User;



define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("PAGEVIEW", "view");
define("PAGELIST", "list");

define("PAGEPERMISSION", "permission");
define("PAGEROLE", "role");

define("DEFAULTPASSWORD", "password");


function getUsersUsagers()
{
    // Compte le nombre d'utilisateurs ayant le rôle 'Usagers'
    $numberOfUsagers = User::role('Usagers')->count();

    return $numberOfUsagers;
}

function getUsersChauffeurs()
{
    // Compte le nombre d'utilisateurs ayant le rôle 'Usagers'
    $numberOfChauffeurs = User::role('Chauffeur')->count();

    return $numberOfChauffeurs;
}






function userFullName() {
    return auth()->user()->name;
}


function getRolesName() {
    $rolesName = "";
    $i = 0;
    $roles = auth()->user()->roles; // Récupérer les rôles de l'utilisateur une seule fois
    foreach ($roles as $role) {
        $rolesName .= $role->name;

        if ($i < count($roles) - 1) {
            $rolesName .= ",";  // Ajouter une virgule si ce n'est pas le dernier rôle
        }

        $i++;
    }

    return $rolesName;  // Retourner la chaîne contenant les names des rôles
}


function setMenuClass($route, $classe){
    $routeActuel = request()->route()->getName();

    // Vérifie si la route actuelle contient le préfixe de la route donnée
    if(str_contains($routeActuel, $route)){
        return $classe;  // Ouvre le sous-menu si la route correspond
    }
    return "";
}


function setMenuActive($route){
    $routeActuel = request()->route()->getName();

    // Vérifie si la route actuelle est exactement égale à $route
    if($routeActuel === $route){
        return "active";
    }
    return "";
}

if (!function_exists("getPageTitle")) {
    function getPageTitle()
    {
        $routeName = request()->route()->getName();
        $routeTitles = [
            "welcome" => "Tableau de bord",
            "admin.client" => "Client",
            "admin.fournisseur" => "Fournisseur",
            "admin.mouvement_stock" =>"Mouvement de stock",
            "admin.categorie" =>"Categorie",
            "admin.habilitations.users.index" =>"Utilisateurs",
            "admin.rôle-permission" =>"Rôle & Permissions",
            "admin.profil" =>"Profil",
            "admin.inventaire" =>"Inventaire",
            "admin.historique" =>"Historique",
            "admin.produit" =>"Produits",
        ];


        return $routeTitles[$routeName] ?? "Accueil";
    }
}
