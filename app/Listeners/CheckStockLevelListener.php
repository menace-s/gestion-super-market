<?php

namespace App\Listeners;

use App\Events\ProductStockUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

class CheckStockLevelListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductStockUpdated $event): void
    {
        $produit = $event->produit;

        // On vérifie si le produit a un seuil défini et si la quantité est en dessous ou égale
        if ($produit->min_stock > 0 && $produit->quantity <= $produit->min_stock) {
            
            // On trouve le ou les utilisateurs à notifier.
            // Pour l'instant, on prend le premier utilisateur comme exemple.
            // Idéalement, tu filtrerais sur un rôle 'responsable de stock'.
            $userToNotify = User::first(); // À adapter selon ta logique métier

            if ($userToNotify) {
                // On envoie la notification à l'utilisateur trouvé
                Notification::send($userToNotify, new LowStockNotification($produit));
            }
        }
    }
}
