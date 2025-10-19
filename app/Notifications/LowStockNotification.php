<?php

namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected Produit $produit;
    public function __construct(Produit $produit)
    {
        $this->produit = $produit;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->error() // Affiche l'email en mode "alerte"
            ->subject('Alerte de Stock Faible : ' . $this->produit->name)
            ->line("Le produit '{$this->produit->name}' (SKU: {$this->produit->sku}) a atteint son seuil de stock.")
            ->line("Stock actuel : {$this->produit->quantity} | Seuil minimum : {$this->produit->min_stock}")
            ->action('Consulter le produit', url('/produits')) // Adapte ce lien vers la page de détail si tu en as une
            ->line('Veuillez planifier un réapprovisionnement.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->produit->id,
            'product_name' => $this->produit->name,
            'message' => "Le stock pour '{$this->produit->name}' est faible ({$this->produit->quantity}).",
        ];
    }
}
