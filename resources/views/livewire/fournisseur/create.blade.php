<div class="content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="page-title">
            <h4>Nouveau fournisseur</h4>
        </div>
        <div>
            <button class="btn btn-light" wire:click="goToListeFournisseur">Retour</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" class="form-control" wire:model.live="newFournisseur.name">
            @error('newFournisseur.name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Personne de contact</label>
            <input type="text" class="form-control" wire:model.live="newFournisseur.contact_name">
            @error('newFournisseur.contact_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" wire:model.live="newFournisseur.email">
            @error('newFournisseur.email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" wire:model.live="newFournisseur.phone">
            @error('newFournisseur.phone') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Adresse</label>
            <textarea class="form-control" rows="3" wire:model.live="newFournisseur.adress"></textarea>
            @error('newFournisseur.adress') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" wire:click="addFournisseur">Enregistrer</button>
                <button class="btn btn-light" wire:click="goToListeFournisseur">Annuler</button>
            </div>
        </div>
    </div>
</div>
