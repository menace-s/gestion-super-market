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
                {{-- Colonne de gauche : Image (inchangée) --}}
                <div class="col-lg-4 col-sm-12 text-center">
                    @if ($viewProduit->image_path)
                        <img src="{{ Storage::url($viewProduit->image_path) }}" alt="{{ $viewProduit->name }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <img src="{{ asset('assets/img/placeholder.jpg') }}" alt="Pas d'image" class="img-fluid rounded" style="max-height: 300px;">
                    @endif
                </div>

                {{-- Colonne de droite : Informations (inchangée) --}}
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
                    <p class="text">
                        {{ $viewProduit->description ?? 'Aucune description fournie.' }}
                    </p>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                
                <button wire:click.prevent="goToEditProduit({{ $viewProduit->id }})" class="btn btn-primary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 me-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    Modifier le produit
                </button>

                
                <button wire:click.prevent="goToListeProduit" class="btn btn-secondary">
                    Retour
                </button>
            </div>
        </div>
    </div>
</div>