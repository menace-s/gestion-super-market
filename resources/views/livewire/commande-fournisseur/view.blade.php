<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Commande #{{ $viewCommande->reference }}</h4>
            <h6>Détails de la commande</h6>
        </div>
        <div class="page-btn">
            <button wire:click.prevent="goToListeCommandes" class="btn btn-secondary me-2">
                <i data-feather="arrow-left" class="me-2"></i>Retour
            </button>
            @if($viewCommande->statut == 'brouillon')
                <button wire:click.prevent="goToEditCommande({{ $viewCommande->id }})" class="btn btn-primary me-2">
                    <i data-feather="edit" class="me-2"></i>Modifier
                </button>
            @endif
            <button type="button" 
                    class="btn btn-danger"
                    onclick="if(confirm('Voulez-vous vraiment supprimer cette commande ? Cette action est irréversible.')) { @this.call('deleteCommande', {{ $viewCommande->id }}) }">
                <i data-feather="trash-2" class="me-2"></i>Supprimer
            </button>
        </div>
    </div>

    {{-- INFORMATIONS PRINCIPALES --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informations de la commande</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong class="text-muted d-block mb-1">Référence</strong>
                            <span class="fs-6">{{ $viewCommande->reference }}</span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-muted d-block mb-1">Date de commande</strong>
                            <span class="fs-6">{{ \Carbon\Carbon::parse($viewCommande->date_commande)->format('d/m/Y') }}</span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-muted d-block mb-1">Statut</strong>
                            <span class="badge 
                                @if($viewCommande->statut == 'brouillon') bg-secondary
                                @elseif($viewCommande->statut == 'envoyee') bg-primary
                                @elseif($viewCommande->statut == 'recue') bg-success
                                @elseif($viewCommande->statut == 'annulee') bg-danger
                                @endif fs-6">
                                {{ ucfirst($viewCommande->statut) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong class="text-muted d-block mb-1">Fournisseur</strong>
                            <span class="fs-6">{{ $viewCommande->fournisseur->name }}</span>
                            @if($viewCommande->fournisseur->email)
                                <br><small class="text-muted">
                                    <i data-feather="mail" style="width: 14px; height: 14px;"></i>
                                    {{ $viewCommande->fournisseur->email }}
                                </small>
                            @endif
                            @if($viewCommande->fournisseur->phone)
                                <br><small class="text-muted">
                                    <i data-feather="phone" style="width: 14px; height: 14px;"></i>
                                    {{ $viewCommande->fournisseur->phone }}
                                </small>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <strong class="text-muted d-block mb-1">Date de création</strong>
                            <span class="fs-6">{{ $viewCommande->created_at->format('d/m/Y à H:i') }}</span>
                            
                            @if($viewCommande->updated_at != $viewCommande->created_at)
                                <br>
                                <strong class="text-muted d-block mb-1 mt-2">Dernière modification</strong>
                                <span class="fs-6">{{ $viewCommande->updated_at->format('d/m/Y à H:i') }}</span>
                            @endif
                        </div>
                    </div>

                    @if($viewCommande->notes)
                        <hr>
                        <div>
                            <strong class="text-muted d-block mb-2">Notes</strong>
                            <p class="mb-0">{{ $viewCommande->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RÉSUMÉ --}}
        <div class="col-lg-4">
            

            {{-- ACTIONS RAPIDES --}}
            @if($viewCommande->statut == 'brouillon')
                <div class="card border-warning">
                    <div class="card-body">
                        <h6 class="card-title text-warning mb-3">
                            <i data-feather="alert-circle" class="me-2"></i>
                            Commande en brouillon
                        </h6>
                        <p class="card-text small mb-3">
                            Cette commande est encore en brouillon. Vous pouvez la modifier ou la valider.
                        </p>
                        <button wire:click.prevent="goToEditCommande({{ $viewCommande->id }})" 
                                class="btn btn-warning btn-sm w-100">
                            <i data-feather="edit-2" class="me-2"></i>
                            Modifier la commande
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    
    {{-- LISTE DES PRODUITS --}}
    <div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">
            <i data-feather="package" class="me-2"></i>
            Produits commandés ({{ $viewCommande->produits->count() }})
        </h5>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        {{-- On enlève la colonne '#' et on donne plus de place au produit --}}
                        <th style="width: 45%;">Produit</th>
                        <th style="width: 15%;" class="text-center">Quantité</th>
                        <th style="width: 20%;" class="text-end">Prix unitaire</th>
                        <th style="width: 20%;" class="text-end">Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($viewCommande->produits as $produit)
                    <tr>
                        <td>
                            {{-- AJOUT : Miniature de l'image pour une meilleure identification --}}
                            <div class="d-flex align-items-center">
                                <img 
                                    src="{{ $produit->image_path ? Storage::url($produit->image_path) : asset('assets/img/placeholder.jpg') }}" 
                                    alt="{{ $produit->name }}"
                                    class="rounded me-3"
                                    style="width: 40px; height: 40px; object-fit: cover;"
                                >
                                <div>
                                    <div class="fw-bold">{{ $produit->name }}</div>
                                    @if($produit->sku)
                                        <small class="text-muted">SKU: {{ $produit->sku }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-light border text-dark fs-6">
                                {{ $produit->pivot->quantite_commandee }}
                            </span>
                        </td>
                        <td class="text-end align-middle">
                            {{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="text-end align-middle fw-bold">
                            {{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite_commandee, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- Le colspan passe à 4 --}}
                        <td colspan="4" class="text-center text-muted py-4">
                            <i data-feather="inbox" class="mb-2"></i>
                            <p class="mb-0">Aucun produit dans cette commande.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- AMÉLIORATION : La section des totaux est maintenant séparée pour plus de clarté --}}
        @if($viewCommande->produits->count() > 0)
        <div class="row justify-content-end mt-4">
            <div class="col-lg-5 col-md-7">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total des articles
                        <span class="fw-bold">{{ $viewCommande->produits->sum('pivot.quantite_commandee') }}</span>
                    </li>
                    {{-- Tu pourrais ajouter la TVA ou les frais de port ici plus tard --}}
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-primary">
                        <strong class="fs-5">MONTANT TOTAL</strong>
                        <strong class="fs-5">{{ number_format($viewCommande->total, 0, ',', ' ') }} FCFA</strong>
                    </li>
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
</div>

@push('scripts')
<script>
    // Réinitialiser les icônes Feather
    document.addEventListener('livewire:load', function () {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        Livewire.hook('message.processed', (message, component) => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    });
</script>
@endpush