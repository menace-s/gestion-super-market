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
            // $stockManagers = User::role('Responsable Stocks')->get();
            $usersToNotify = User::role(['Responsable Stocks', 'Administrateur'])->get();

            // On s'assure qu'il y a au moins un responsable à notifier
            if ($usersToNotify->isNotEmpty()) {
                // Laravel enverra la notification à chaque utilisateur de la collection
                Notification::send($usersToNotify, new LowStockNotification($produit));
            }
        }
    }
}
