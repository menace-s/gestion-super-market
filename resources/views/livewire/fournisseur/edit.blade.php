<div class="content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="page-title">
            <h4>Modifier le fournisseur</h4>
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
            <input type="text" class="form-control" wire:model.live="editFournisseur.name">
            @error('editFournisseur.name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Personne de contact</label>
            <input type="text" class="form-control" wire:model.live="editFournisseur.contact_name">
            @error('editFournisseur.contact_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" wire:model.live="editFournisseur.email">
            @error('editFournisseur.email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" wire:model.live="editFournisseur.phone">
            @error('editFournisseur.phone') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Adresse</label>
            <textarea class="form-control" rows="3" wire:model.live="editFournisseur.adress"></textarea>
            @error('editFournisseur.adress') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" wire:click="updateFournisseur">Mettre à jour</button>
                <button class="btn btn-light" wire:click="goToListeFournisseur">Annuler</button>
            </div>
        </div>
    </div>
</div>
