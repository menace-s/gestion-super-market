<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationsBell extends Component
{
    public $unreadCount = 0;

    // Le #[On(...)] permet de rafraîchir le composant en temps réel
    // quand une nouvelle notification arrive.
    #[On('notification-received')]
    public function mount()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }
        
        // Redirige vers la page du produit (exemple)
        // Tu peux rendre cette URL dynamique en la stockant dans la notification
        return redirect()->to('/produits');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->mount(); // On rafraîchit le compteur
    }

    public function render()
    {
        $notifications = [];
        if (Auth::check()) {
            // On récupère les 5 dernières notifications pour l'affichage
            $notifications = Auth::user()->notifications()->latest()->take(5)->get();
        }
        
        return view('livewire.notifications-bell', [
            'notifications' => $notifications
        ]);
    }
}