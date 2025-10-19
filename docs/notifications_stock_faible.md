# Guide d'Implémentation : Notifications de Stock Faible

Ce document explique comment mettre en place un système de notification pour alerter les responsables lorsque le stock d'un produit atteint son seuil minimum.

## Architecture

Le système repose sur l'architecture Événementielle de Laravel pour découpler la logique métier de la logique de notification.

1.  **Déclencheur** : Une action (ex: mise à jour d'un produit) modifie la quantité en stock.
2.  **Événement `ProductStockUpdated`** : L'action déclenche cet événement, qui sert de signal.
3.  **Écouteur `CheckStockLevelListener`** : Il intercepte l'événement, vérifie si `quantité <= seuil`.
4.  **Notification `LowStockNotification`** : Si le seuil est atteint, l'écouteur envoie cette notification.
5.  **Canaux** : La notification est envoyée par e-mail et stockée en base de données pour un affichage sur l'interface.

---

## Guide d'Installation Rapide

### 1. Création des Fichiers de Base (Artisan)

```bash
# Créer l'événement, la notification et l'écouteur
php artisan make:event ProductStockUpdated
php artisan make:notification LowStockNotification
php artisan make:listener CheckStockLevelListener --event=ProductStockUpdated

# Créer la migration pour la table des notifications
php artisan notifications:table
php artisan migrate
```

### 2. Configuration du Code

**A. L'Événement (`app/Events/ProductStockUpdated.php`)**
Doit accepter un objet `Produit` dans son constructeur.

```php
// ...
public function __construct(Produit $produit)
{
    $this->produit = $produit;
}
// ...
```

**B. La Notification (`app/Notifications/LowStockNotification.php`)**
Configure les canaux (`via()`), le message d'email (`toMail()`) et le format pour la base de données (`toArray()`).

```php
// ...
public function via(object $notifiable): array
{
    return ['mail', 'database'];
}

public function toMail(object $notifiable): MailMessage
{
    // ... configurer le message ...
}

public function toArray(object $notifiable): array
{
    // ... configurer les données pour la BDD ...
}
// ...
```

**C. L'Écouteur (`app/Listeners/CheckStockLevelListener.php`)**
Contient la logique de vérification et d'envoi.

```php
// ...
public function handle(ProductStockUpdated $event): void
{
    $produit = $event->produit;

    if ($produit->min_stock > 0 && $produit->quantity <= $produit->min_stock) {
        $userToNotify = User::where('role', 'stock_manager')->first(); // Adapter la logique pour trouver le bon utilisateur
        if ($userToNotify) {
            Notification::send($userToNotify, new LowStockNotification($produit));
        }
    }
}
// ...
```

**D. Enregistrement (Auto-Discovery)**
Assure-toi que la découverte automatique est activée dans `app/Providers/EventServiceProvider.php` (c'est le défaut). Il n'est pas nécessaire d'enregistrer manuellement l'écouteur dans le tableau `$listen`.

### 3. Déclenchement de l'Événement

Aux endroits où la quantité d'un produit est modifiée (ex: `ProduitComp@updateProduit`), ajoute la ligne suivante :

```php
use App\Events\ProductStockUpdated;

ProductStockUpdated::dispatch($produit);
```

### 4. Affichage Frontend (Composant Livewire)

1.  Créer un composant pour la cloche : `php artisan make:livewire NotificationsBell`.
2.  Dans ce composant, récupérer les notifications de l'utilisateur (`Auth::user()->notifications`).
3.  Intégrer le composant dans le layout avec `<livewire:notifications-bell />`.
4.  Pour le rafraîchissement en temps réel, déclencher un événement Livewire depuis le composant qui modifie le stock.

    ```php
    // Dans ProduitComp.php après la mise à jour
    $this->dispatch('notification-received');
    ```

    Et l'écouter dans `NotificationsBell.php`.

    ```php
    // Dans NotificationsBell.php
    #[On('notification-received')]
    public function mount()
    {
        // ... rafraîchir le compteur ...
    }
    ```

---