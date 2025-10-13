<div wire:ignore.self>

   <div>
    {{-- La section d'en-tête et le bouton d'ajout --}}
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Liste des Catégories</h4>
                    <h6>Gérer les catégories de produits</h6>
                </div>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" wire:click="goToAddCategorie()" class="btn btn-added">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Nouvelle Catégorie
                </a>
            </div>
        </div>

        {{-- La carte contenant la table --}}
        <div class="card">
            <div class="card-header">
                <div class="search-set">
                    <div class="search-input">
                         <input wire:model.live.debounce.300ms="search" type="search" class="form-control form-control-sm" placeholder="Rechercher une catégorie...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            {{-- BONNE PRATIQUE : wire:key est essentiel pour les optimisations de Livewire --}}
                            <tr wire:key="{{ $category->id }}">
                                <td>{{ $category->name }}</td>
                                <td>{{ Str::limit($category->description, 50, '...') }}</td>
                                <td class="action-table-data text-center" style="justify-content: center">
                                    <div class="edit-delete-action">
                                        <a wire:click="goToEditCategory({{ $category->id }})" class="me-2 p-2" href="javascript:void(0);" title="Modifier">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        
                                        {{-- CORRECTION : S'assurer que la permission est correcte --}}
                                        {{-- @can('gérer catégories') --}}
                                        <a wire:click="confirmDelete({{ $category->id }})" href="javascript:void(0);" class="p-2" title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </a>
                                        {{-- @endcan --}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucune catégorie trouvée.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODALE D'AJOUT --}}
    <div wire:ignore.self class="modal fade" id="FormModalAdd" tabindex="-1" aria-labelledby="FormModalAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FormModalAddLabel">Ajouter une nouvelle catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addCategory()">
                        <div class="mb-3">
                            <label for="add-name" class="form-label">Nom de la catégorie</label>
                            <input placeholder="Ex: Électronique, Livres..." type="text" class="form-control" id="add-name" wire:model="newCategorie.name">
                            @error('newCategorie.name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="add-description" class="form-label">Description (Optionnel)</label>
                            <textarea placeholder="Brève description de la catégorie." class="form-control" id="add-description" wire:model="newCategorie.description" rows="3"></textarea>
                            @error('newCategorie.description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALE DE MODIFICATION --}}
    <div wire:ignore.self class="modal fade" id="FormModalEdit" tabindex="-1" aria-labelledby="FormModalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FormModalEditLabel">Modifier la catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateCategory">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nom de la catégorie</label>
                            <input placeholder="Ex: Électronique, Livres..." type="text" class="form-control" id="edit-name" wire:model="editCategorie.name">
                            @error('editCategorie.name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Description (Optionnel)</label>
                            <textarea placeholder="Brève description de la catégorie." class="form-control" id="edit-description" wire:model="editCategorie.description" rows="3"></textarea>
                            @error('editCategorie.description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- MEILLEURE PRATIQUE : Un seul bloc de script à la fin --}}
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Gestionnaires pour les modales Bootstrap
        const addModal = new bootstrap.Modal(document.getElementById('FormModalAdd'));
        const editModal = new bootstrap.Modal(document.getElementById('FormModalEdit'));

        @this.on('show-add-modal', () => {
            addModal.show();
        });

        @this.on('show-edit-modal', () => {
            editModal.show();
        });

        // Livewire peut aussi fermer les modales après une action réussie
        document.addEventListener('close-modal', () => {
            addModal.hide();
            editModal.hide();
        });

        // Gestionnaire pour les messages de succès (Toast)
        @this.on('showSuccessMessage', (event) => {
            // Livewire 3 simplifie l'accès, plus besoin de .detail
            const data = event[0] || {};
            Swal.fire({
                position: 'top-end',
                icon: data.type || 'success',
                toast: true,
                title: data.message || "Opération effectuée avec succès!",
                showConfirmButton: false,
                timer: 3000
            });
        });

        // LE SCRIPT DE CONFIRMATION CORRIGÉ
        @this.on('showConfirmMessage', (event) => {
            const data = event[0] || {}; // On accède directement aux données
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // On renvoie un événement au composant pour exécuter la suppression
                    @this.dispatch('deleteCategory', { id: data.data.category_id });
                }
            });
        });
    });
</script>
@endpush
</div>

</div>
