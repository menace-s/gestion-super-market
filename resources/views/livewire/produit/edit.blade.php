<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Modification de Produit</h4>
            <h6>Mettre à jour les informations du produit "{{ $editProduit['name'] ?? '' }}"</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form wire:submit.prevent="updateProduit">
                
                {{-- SECTION 1 : Informations principales du produit --}}
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Nom du Produit</label>
                            <input type="text" class="form-control" wire:model="editProduit.name" placeholder="Ex: iPhone 15 Pro">
                            @error('editProduit.name') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">SKU (Code Article)</label>
                            <input type="text" class="form-control" wire:model="editProduit.sku" placeholder="Ex: SKU-12345">
                             @error('editProduit.sku') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select" wire:model="editProduit.category_id">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                             @error('editProduit.category_id') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECTION 2 : Prix et Stock --}}
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Prix d'Achat</label>
                            <input type="number" step="any" class="form-control" wire:model="editProduit.prix_achat">
                             @error('editProduit.prix_achat') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Prix de Vente</label>
                            <input type="number" step="any" class="form-control" wire:model="editProduit.prix_vente">
                             @error('editProduit.prix_vente') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Quantité en Stock</label>
                            <input type="number" class="form-control" wire:model="editProduit.quantity">
                             @error('editProduit.quantity') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Stock Minimum</label>
                            <input type="number" class="form-control" wire:model="editProduit.min_stock">
                             @error('editProduit.min_stock') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">

                {{-- SECTION 3 : Description et Image --}}
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" wire:model="editProduit.description" rows="8" placeholder="Description détaillée du produit"></textarea>
                             @error('editProduit.description') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Changer l'image</label>
                            <input type="file" class="form-control" wire:model="newImage" id="newProductImageUpload">
                            @error('newImage') <span class="text-danger mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div wire:loading wire:target="newImage" class="w-100">
                             <div class="alert alert-info">Téléchargement de l'image...</div>
                        </div>

                        {{-- Logique d'affichage de l'image : nouvelle, actuelle, ou placeholder --}}
                        @if ($newImage)
                            <div class="mt-3 text-center">
                                <img src="{{ $newImage->temporaryUrl() }}" alt="Aperçu de la nouvelle image" class="img-fluid rounded" style="max-height: 200px;">
                                <p class="text-muted mt-2">Prévisualisation</p>
                            </div>
                        @elseif (!empty($editProduit['image_path']))
                             <div class="mt-3 text-center">
                                <img src="{{ Storage::url($editProduit['image_path']) }}" alt="Image actuelle" class="img-fluid rounded" style="max-height: 200px;">
                                <p class="text-muted mt-2">Image actuelle</p>
                            </div>
                        @else
                            <div class="mt-3">
                                <label for="newProductImageUpload" style="cursor: pointer; display: block; border: 2px dashed #ccc; border-radius: 8px; padding: 2rem; text-align: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload-cloud text-muted mb-2"><polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                                    <span class="d-block text-muted">Aucune image. <br>Cliquez pour en ajouter une.</span>
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
                            <input class="form-check-input" type="checkbox" role="switch" id="productStatusSwitchEdit" wire:model="editProduit.is_active">
                            <label class="form-check-label" for="productStatusSwitchEdit">Produit Actif</label>
                        </div>
                        <p class="form-text mt-2">
                            Les produits inactifs ne seront pas visibles par les clients sur le site public.
                        </p>
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECTION 4 : Actions --}}
                <div class="d-flex justify-content-end">
                    <button type="button" wire:click.prevent="goToListeProduit" class="btn btn-secondary me-2">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="updateProduit">
                            Mettre à jour le Produit
                        </span>
                        <span wire:loading wire:target="updateProduit">
                            Mise à jour...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>