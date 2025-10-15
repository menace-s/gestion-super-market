<div class="content">

    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Liste des Fournisseurs</h4>
                <h6>Gérer tous les fournisseurs</h6>
            </div>
        </div>
        <div class="page-btn">
            <a href="javascript:void(0);" wire:click="goToAddUser" class="btn btn-added">
                <img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img">
                Nouveau Fournisseur
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Barre de recherche “style produits” --}}
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                            <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <div class="dataTables_filter">
                            <label>
                                <input wire:model.live.debounce.300ms='search' type="search"
                                    class="form-control" placeholder="Rechercher un fournisseur..."
                                    aria-controls="DataTables_Table_0">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                {{-- même classe que les autres listes pour garder l’UI identique --}}
                <table class="table dashboard-expired-products">
                    <thead>
                        <tr>
                            <th>Nom & prénom</th>
                            <th>Adresse e-mail</th>
                            <th>Numéro de téléphone</th>
                            <th>Ajouté</th>
                            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fournisseurs as $f)
                        <tr wire:key="f{{ $f->id }}">
                            <td>{{ $f->name }}</td>
                            <td>{{ $f->email ?? '—' }}</td>
                            <td>{{ $f->phone ?? '—' }}</td>
                            <td>{{ optional($f->created_at)->format('d/m/Y') }}</td>

                            <td class="action-table-data text-center" style="justify-content: center">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="javascript:void(0);" title="Modifier"
                                        wire:click="goToEditUser({{ $f->id }})">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="edit">
                                    </a>

                                    <a class="p-2" href="javascript:void(0);" title="Supprimer"
                                        wire:click="confirmDelete({{ $f->id }})">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="delete">
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucun fournisseur trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (pareil que Produits) --}}
            <div class="mt-3">
                {{ $fournisseurs->links() }}
            </div>
        </div>
    </div>

    {{-- ==================== MODALE AJOUT ==================== --}}
    <div wire:ignore.self class="modal fade" id="FormModalAdd" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit.prevent="addUser">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un fournisseur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"
                        wire:click="closeModals"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Nom & prénom"
                            wire:model.defer="name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Adresse e-mail"
                            wire:model.defer="email">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-0">
                        <input type="text" class="form-control" placeholder="Numéro de téléphone"
                            wire:model.defer="phone">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal" wire:click="closeModals">Fermer</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ==================== MODALE EDIT ==================== --}}
    <div wire:ignore.self class="modal fade" id="FormModalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit.prevent="updateUser">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier un fournisseur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"
                        wire:click="closeModals"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Nom & prénom"
                            wire:model.defer="name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Adresse e-mail"
                            wire:model.defer="email">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-0">
                        <input type="text" class="form-control" placeholder="Numéro de téléphone"
                            wire:model.defer="phone">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal" wire:click="closeModals">Fermer</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- === SCRIPTS (même pattern que Produits) === --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Modales Bootstrap
        const addModal = new bootstrap.Modal(document.getElementById('FormModalAdd'));
        const editModal = new bootstrap.Modal(document.getElementById('FormModalEdit'));
        window.addEventListener('show-add-modal', () => addModal.show());
        window.addEventListener('show-edit-modal', () => editModal.show());
        window.addEventListener('close-modals', () => {
            addModal.hide();
            editModal.hide();
        });

        // ✅ Success (v2 & v3)
        window.addEventListener('showSuccessMessage', (e) => {
            const msg = e?.detail?.message ?? e?.detail?.[0]?.message ?? 'Opération effectuée avec succès !';
            if (window.Swal) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    toast: true,
                    title: msg,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert(msg);
            }
        });

        // ✅ Confirmation (v2 & v3)
        window.addEventListener('showConfirmMessage', (e) => {
            const payload = e?.detail?.message ?? e?.detail ?? {};
            const id = payload.id ?? payload.Fournisseur_id;
            const title = payload.title || 'Confirmation';
            const text = payload.text || 'Voulez-vous continuer ?';
            const icon = payload.type || 'warning';

            const callDelete = (id) => {
                if (window.Livewire?.dispatch) {
                    Livewire.dispatch('deleteFournisseur', {
                        id
                    });
                    return;
                } // v3
                if (window.Livewire?.emit) {
                    Livewire.emit('deleteFournisseur', id);
                    return;
                } // v2
                console.error('Livewire non initialisé');
            };

            if (window.Swal) {
                Swal.fire({
                    title,
                    text,
                    icon,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    cancelButtonText: 'Annuler',
                    reverseButtons: true, // ⬅️ Confirmer à droite, Annuler à gauche
                    confirmButtonColor: '#0a0f2b',
                    cancelButtonColor: '#c91594',
                }).then(res => {
                    if (res.isConfirmed && id) callDelete(id);
                });
            } else {
                if (confirm(text) && id) callDelete(id);
            }
        });
    });
</script>