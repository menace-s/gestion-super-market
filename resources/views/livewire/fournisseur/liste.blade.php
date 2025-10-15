<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Liste des Fournisseurs</h4>
                <h6>Fournisseurs</h6>
            </div>
        </div>
        <div class="page-btn">
            <a wire:click="goToAddFournisseur" class="btn btn-added" href="javascript:void(0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Nouveau Fournisseur
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center gap-3">
            <div class="form-group mb-0 flex-grow-1">
                <input type="text" class="form-control" placeholder="Rechercher (nom, contact, email, téléphone, adresse)"
                       wire:model.live.debounce.500ms="search">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $it)
                            <tr>
                                <td class="fw-semibold">{{ $it->name }}</td>
                                <td>{{ $it->contact_name }}</td>
                                <td>{{ $it->email }}</td>
                                <td>{{ $it->phone }}</td>
                                <td>{{ Str::limit($it->adress, 60) }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-secondary" wire:click="goToViewFournisseur({{ $it->id }})">Voir</button>
                                        <button class="btn btn-sm btn-outline-primary" wire:click="goToEditFournisseur({{ $it->id }})">Éditer</button>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="confirmDeleteFournisseur({{ $it->id }})">Supprimer</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Aucun fournisseur</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
