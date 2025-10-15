<div class="content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="page-title">
            <h4>Détails fournisseur</h4>
        </div>
        <div>
            <button class="btn btn-light" wire:click="goToListeFournisseur">Retour</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($viewFournisseur)
            <dl class="row">
                <dt class="col-sm-3">Nom</dt>
                <dd class="col-sm-9">{{ $viewFournisseur->name }}</dd>

                <dt class="col-sm-3">Contact</dt>
                <dd class="col-sm-9">{{ $viewFournisseur->contact_name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $viewFournisseur->email }}</dd>

                <dt class="col-sm-3">Téléphone</dt>
                <dd class="col-sm-9">{{ $viewFournisseur->phone }}</dd>

                <dt class="col-sm-3">Adresse</dt>
                <dd class="col-sm-9">{{ $viewFournisseur->adress }}</dd>
            </dl>
            @endif
        </div>
    </div>
</div>
