{{-- resources/views/livewire/produit/view.blade.php --}}
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Détails du Produit</h4>
            <h6>Vue complète des informations du produit</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Colonne de gauche : Image --}}
                <div class="col-lg-4 col-sm-12 text-center">
                    @if ($viewProduit->image_path)
                        <img src="{{ Storage::url($viewProduit->image_path) }}" alt="{{ $viewProduit->name }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <img src="{{ asset('assets/img/placeholder.jpg') }}" alt="Pas d'image" class="img-fluid rounded" style="max-height: 300px;">
                    @endif
                </div>

                {{-- Colonne de droite : Informations --}}
                <div class="col-lg-8 col-sm-12">
                    <h3 class="mb-3">{{ $viewProduit->name }}</h3>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>SKU (Code Article)</strong>
                            <span>{{ $viewProduit->sku }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Catégorie</strong>
                            <span>{{ $viewProduit->category->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Prix de Vente</strong>
                            <span class="text-success fw-bold">{{ number_format($viewProduit->prix_vente, 0, ',', ' ') }} FCFA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Prix d'Achat</strong>
                            <span>{{ number_format($viewProduit->prix_achat, 0, ',', ' ') }} FCFA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Quantité en Stock</strong>
                            <span>{{ $viewProduit->quantity }} unités</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Stock Minimum</strong>
                            <span>{{ $viewProduit->min_stock }} unités</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Statut</strong>
                            @if($viewProduit->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </li>
                    </ul>

                    <h5 class="mt-4">Description</h5>
                    <p>
                        {{ $viewProduit->description ?? 'Aucune description fournie.' }}
                    </p>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                <button wire:click.prevent="goToListeProduit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Retour à la liste
                </button>
            </div>
        </div>
    </div>
</div>