{{-- resources/views/livewire/produit/create.blade.php --}}
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Création de Produit</h4>
            <h6>Ajouter un nouveau produit à votre catalogue</h6>
        </div>
    </div>

    {{-- La carte principale qui contient tout le formulaire pour un look propre et délimité --}}
    <div class="card">
        {{-- On ajoute un padding intérieur (p-4) pour que les éléments ne soient pas collés aux bords --}}
        <div class="card-body p-4">
            <form wire:submit.prevent="addProduit">
                
                {{-- SECTION 1 : Informations principales du produit --}}
                <div class="row">
                    {{-- On utilise col-md-6 pour passer à 2 colonnes sur les écrans moyens (tablettes) et plus grands --}}
                    {{-- Et col-lg-4 pour passer à 3 colonnes sur les grands écrans (desktop) --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        {{-- mb-3 (margin-bottom) est notre meilleur ami pour l'espacement vertical --}}
                        <div class="form-group mb-3">
                            <label class="form-label">Nom du Produit</label>
                            <input type="text" class="form-control" wire:model="newProduit.name" placeholder="Ex: iPhone 15 Pro">
                            @error('newProduit.name') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">SKU (Code Article)</label>
                            <input type="text" class="form-control" wire:model="newProduit.sku" placeholder="Ex: SKU-12345">
                             @error('newProduit.sku') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select" wire:model="newProduit.category_id">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                             @error('newProduit.category_id') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4"> {{-- Un séparateur visuel pour délimiter les sections --}}

                {{-- SECTION 2 : Prix et Stock --}}
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Prix d'Achat</label>
                            <input type="number" step="any" class="form-control" wire:model="newProduit.prix_achat">
                             @error('newProduit.prix_achat') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Prix de Vente</label>
                            <input type="number" step="any" class="form-control" wire:model="newProduit.prix_vente">
                             @error('newProduit.prix_vente') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Quantité en Stock</label>
                            <input type="number" class="form-control" wire:model="newProduit.quantity">
                             @error('newProduit.quantity') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Stock Minimum</label>
                            <input type="number" class="form-control" wire:model="newProduit.min_stock">
                             @error('newProduit.min_stock') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">

                {{-- SECTION 3 : Description et Image --}}
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" wire:model="newProduit.description" rows="8" placeholder="Description détaillée du produit"></textarea>
                            @error('newProduit.description') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Image du Produit</label>
                            <input type="file" class="form-control" wire:model="image" id="productImageUpload">
                            @error('image') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div wire:loading wire:target="image" class="w-100">
                             <div class="alert alert-info">Téléchargement de l'image...</div>
                        </div>

                        {{-- On gère les deux états : avec et sans image sélectionnée --}}
                        @if ($image)
                            {{-- CAS 1 : Une image est sélectionnée, on affiche la prévisualisation --}}
                            <div class="mt-3 text-center">
                                <img src="{{ $image->temporaryUrl() }}" alt="Aperçu de l'image" class="img-fluid rounded" style="max-height: 200px;">
                                <p class="text-muted mt-2">Prévisualisation</p>
                            </div>
                        @else
                            {{-- CAS 2 : Aucune image, on affiche un placeholder cliquable --}}
                            <div class="mt-3">
                                <label for="productImageUpload" style="cursor: pointer; display: block; border: 2px dashed #ccc; border-radius: 8px; padding: 2rem; text-align: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload-cloud text-muted mb-2"><polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                                    <span class="d-block text-muted">Cliquez pour choisir une image</span>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>


                <hr class="my-4">

{{-- SECTION STATUT --}}
<div class="row">
    <div class="col-12">
        <h6 class="mb-3">Statut du Produit</h6>
        <div class="form-check form-switch">
            <input 
                class="form-check-input" 
                type="checkbox" 
                role="switch" 
                id="productStatusSwitch" 
                wire:model="newProduit.is_active"
            >
            <label class="form-check-label" for="productStatusSwitch">Produit Actif</label>
        </div>
        <p class="form-text mt-2">
            Les produits inactifs ne seront pas visibles par les clients sur le site public.
        </p>
    </div>
</div>
                <hr class="my-4">

                {{-- SECTION 4 : Actions --}}
                
                <div class="d-flex justify-content-end">
                    {{-- On ajoute .prevent au wire:click pour qu'il fonctionne correctement --}}
                    <button type="button" wire:click.prevent="goToListeProduit" class="btn btn-secondary me-2">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="addProduit">
                            Enregistrer le Produit
                        </span>
                        <span wire:loading wire:target="addProduit">
                            Enregistrement...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>