<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Créer une Nouvelle Commande Fournisseur</h4>
            <h6>Étape 1 : Choisir le fournisseur et la date</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Fournisseur</label>
                            <select class="form-select" wire:model="fournisseur_id">
                                <option value="">-- Sélectionnez un fournisseur --</option>
                                @foreach ($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id }}">{{ $fournisseur->name }}</option>
                                @endforeach
                            </select>
                            @error('fournisseur_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Date de la Commande</label>
                            <input type="date" class="form-control" wire:model="date_commande">
                            @error('date_commande') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Notes (Optionnel)</label>
                            <textarea wire:model="notes" class="form-control" rows="3" placeholder="Ajoutez des notes ou des instructions spéciales pour cette commande..."></textarea>
                            @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                
                <hr>

                <div class="d-flex justify-content-end">
                    <button type="button" wire:click.prevent="goToListeCommandes" class="btn btn-secondary me-2">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="store">
                            Créer et Ajouter des Produits
                        </span>
                        <span wire:loading wire:target="store">
                            Création...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>