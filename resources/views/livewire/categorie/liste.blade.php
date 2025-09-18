{{-- resources/views/livewire/category-manager.blade.php --}}
<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Liste des Catégories</h4>
                <h6>Gérer les catégories de produits</h6>
            </div>
        </div>
        <div class="page-btn">
            <a wire:click="goToAddCategorie()" class="btn btn-added">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Nouvelle Catégorie
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                         <input wire:model.live.debounce.300ms='search' type="search" class="form-control form-control-sm" placeholder="Rechercher une catégorie...">
                    </div>
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
                            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            {{-- BONNE PRATIQUE : Tronquer la description si elle est trop longue --}}
                            <td>{{ Str::limit($category->description, 50, '...') }}</td>
                            <td class="action-table-data" style="justify-content: center">
                                <div class="edit-delete-action" style="text-align: center">
                                    <a  wire:click="goToEditCategory({{ $category->id }})" class="me-2 p-2" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    @can('Supprimer un utilisateur')


                                    <a wire:click="confirmDelete()" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                    @endcan
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
    
    <div wire:ignore.self class="modal fade" id="FormModalAdd" tabindex="-1" aria-labelledby="FormModalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FormModalAddLabel">Ajouter une nouvelle catégorie</h5>
                <button type="button" class="btn-close" wire:click="closeModals" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="addCategory()">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de la catégorie</label>
                        <input placeholder="Ex: Électronique, Livres, Vêtements..." type="text" class="form-control" id="name" wire:model.defer="newCategorie.name">
                        @error('newCategorie.name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optionnel)</label>
                        <textarea placeholder="Une brève description de ce que contient cette catégorie." class="form-control" id="description" wire:model.defer="newCategorie.description" rows="3"></textarea>
                        @error('newCategorie.description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer la catégorie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="FormModalEdit" tabindex="-1" aria-labelledby="FormModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FormModalEditLabel">Modifier la catégorie</h5>
                <button type="button" class="btn-close" wire:click="closeModals" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateCategory">
                     <div class="mb-3">
                        <label for="name" class="form-label">Nom de la catégorie</label>
                        <input placeholder="Ex: Électronique, Livres, Vêtements..." type="text" class="form-control" id="name" wire:model.defer="editCategorie.name">
                        @error('editCategorie.name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optionnel)</label>
                        <textarea placeholder="Une brève description de ce que contient cette catégorie." class="form-control" id="description" wire:model.defer="editCategorie.description" rows="3"></textarea>
                        @error('editCategorie.description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" wire:click="closeModals" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Le script pour gérer l'ouverture/fermeture des modales reste très similaire --}}
<script>
        window.addEventListener('show-add-modal', event => {
            const modal = new bootstrap.Modal(document.getElementById('FormModalAdd'));
            modal.show();
        });

        window.addEventListener('show-edit-modal', event => {
            const modal = new bootstrap.Modal(document.getElementById('FormModalEdit'));
            modal.show();
        });
</script>

<script>
    window.addEventListener("showSuccessMessage", event=>{

    Swal.fire({
    position: 'top-end',
    icon: 'success',
    toast:true,
    title: event.detail.message || "Opération effectuée avec succès!",
    showConfirmButton: false,
    timer: 3000
    })
    })
</script>



<script>
    window.addEventListener("showConfirmMessage", event => {

        const messageArray = event.detail; // event.detail est un tableau
        const message = messageArray[0]?.message; // Accédez au premier élément

        if (message && message.title && message.text && message.type) {
            Swal.fire({
                title: message.title,
                text: message.text,
                icon: message.type,
                showCancelButton: true,
                confirmButtonColor: '#0a0f2b',
                cancelButtonColor: '#c91594',
                confirmButtonText: 'Continuer',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deleteUser(message.data.user_id);
                }
            });
        } else {
            console.error('Le message ou ses propriétés sont undefined', message);
        }
    });

</script>