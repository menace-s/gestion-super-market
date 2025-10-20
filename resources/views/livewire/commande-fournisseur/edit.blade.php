<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Modifier la Commande #{{ $editCommande->reference }}</h4>
            <h6>Modifier les informations et gérer les produits</h6>
        </div>
        <div class="page-btn">
            <button wire:click.prevent="goToListeCommandes" class="btn btn-secondary">
                <i data-feather="arrow-left" class="me-2"></i>Retour
            </button>
        </div>
    </div>

    {{-- FORMULAIRE DE MODIFICATION DES INFORMATIONS GÉNÉRALES --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Informations générales</h5>
            
            <form wire:submit.prevent="updateCommande">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fournisseur <span class="text-danger">*</span></label>
                        <select class="form-select" wire:model="edit_fournisseur_id">
                            <option value="">Choisir un fournisseur...</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">{{ $fournisseur->name }}</option>
                            @endforeach
                        </select>
                        @error('edit_fournisseur_id') 
                            <span class="text-danger d-block mt-1">{{ $message }}</span> 
                        @enderror
                        @if($editCommande->fournisseur_id != $edit_fournisseur_id)
                            <small class="text-warning d-block mt-1">
                                <i data-feather="alert-triangle" style="width: 14px; height: 14px;"></i>
                                Attention : Changer le fournisseur supprimera tous les produits de la commande
                            </small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de commande <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" wire:model="edit_date_commande">
                        @error('edit_date_commande') 
                            <span class="text-danger d-block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Statut <span class="text-danger">*</span></label>
                        <select class="form-select" wire:model="edit_statut">
                            <option value="brouillon">Brouillon</option>
                            <option value="envoyee">Envoyée</option>
                            <option value="recue">Reçue</option>
                            <option value="annulee">Annulée</option>
                        </select>
                        @error('edit_statut') 
                            <span class="text-danger d-block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Référence</label>
                        <input type="text" class="form-control" value="{{ $editCommande->reference }}" disabled>
                        <small class="text-muted">La référence ne peut pas être modifiée</small>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" wire:model="edit_notes" rows="3" 
                                  placeholder="Notes supplémentaires..."></textarea>
                        @error('edit_notes') 
                            <span class="text-danger d-block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save" class="me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SECTION DES PRODUITS --}}
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Produits de la commande</h5>
            
            {{-- LISTE DES PRODUITS --}}
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th class="text-end" style="width: 150px;">Prix Unitaire</th>
                            <th class="text-center" style="width: 150px;">Quantité</th>
                            <th class="text-end" style="width: 150px;">Sous-total</th>
                            <th class="text-center" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($editCommande->produits as $produit)
                        <tr>
                            <td>
                                <strong>{{ $produit->name }}</strong>
                                @if($produit->code)
                                    <br><small class="text-muted">Code: {{ $produit->code }}</small>
                                @endif
                            </td>
                            <td class="text-end">
                                {{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="text-center">
                                <div class="input-group input-group-sm" style="max-width: 120px; margin: 0 auto;">
                                    <button class="btn btn-outline-secondary" type="button"
                                            wire:click="updateQuantiteProduit({{ $produit->id }}, {{ $produit->pivot->quantite_commandee - 1 }})"
                                            {{ $produit->pivot->quantite_commandee <= 1 ? 'disabled' : '' }}>
                                        -
                                    </button>
                                    <input type="number" class="form-control text-center" 
                                           value="{{ $produit->pivot->quantite_commandee }}"
                                           wire:change="updateQuantiteProduit({{ $produit->id }}, $event.target.value)"
                                           min="1">
                                    <button class="btn btn-outline-secondary" type="button"
                                            wire:click="updateQuantiteProduit({{ $produit->id }}, {{ $produit->pivot->quantite_commandee + 1 }})">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">
                                <strong>{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite_commandee, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        onclick="if(confirm('Voulez-vous vraiment retirer ce produit de la commande ?')) { @this.call('removeProduitFromCommande', {{ $produit->id }}) }">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i data-feather="package" class="mb-2"></i>
                                <p>Aucun produit ajouté à cette commande.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">TOTAL GÉNÉRAL</td>
                            <td class="text-end fw-bold fs-5 text-primary">
                                {{ number_format($editCommande->total, 0, ',', ' ') }} FCFA
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <hr>

            {{-- FORMULAIRE D'AJOUT DE PRODUIT --}}
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i data-feather="plus-circle" class="me-2"></i>
                        Ajouter un produit
                    </h6>
                    
                    @if(count($produitsDuFournisseur) > 0)
                        <div class="row align-items-end">
                            <div class="col-md-7">
                                <label class="form-label">Produit</label>
                                <select class="form-select" wire:model="produit_id_a_ajouter">
                                    <option value="">Choisir un produit...</option>
                                    @foreach($produitsDuFournisseur as $produit)
                                        <option value="{{ $produit->id }}">
                                            {{ $produit->name }}
                                            @if($produit->pivot && $produit->pivot->prix_fournisseur)
                                                - {{ number_format($produit->pivot->prix_fournisseur, 0, ',', ' ') }} FCFA
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('produit_id_a_ajouter') 
                                    <span class="text-danger d-block mt-1">{{ $message }}</span> 
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Quantité</label>
                                <input type="number" class="form-control" 
                                       wire:model="quantite_a_ajouter" 
                                       min="1" 
                                       value="1">
                                @error('quantite_a_ajouter') 
                                    <span class="text-danger d-block mt-1">{{ $message }}</span> 
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <button type="button" 
                                        class="btn btn-success w-100" 
                                        wire:click.prevent="addProduitToCommande">
                                    <i data-feather="plus" class="me-1"></i>Ajouter
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i data-feather="alert-triangle" class="me-2"></i>
                            Aucun produit disponible pour ce fournisseur. Veuillez d'abord associer des produits au fournisseur.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fonction de confirmation de suppression
    function confirmDelete(produitId) {
        if (confirm('Voulez-vous vraiment retirer ce produit de la commande ?')) {
            @this.call('removeProduitFromCommande', produitId);
        }
    }

    // Réinitialiser les icônes Feather après chaque mise à jour Livewire
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    });
</script>
@endpush