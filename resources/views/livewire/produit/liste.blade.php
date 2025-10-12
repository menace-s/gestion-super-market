<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Liste des Produits</h4>
                <h6>Gérer tous les produits</h6>
            </div>
        </div>
        <div class="page-btn">
            {{-- BONNE PRATIQUE : Le texte du bouton doit correspondre à l'action --}}
            <a href="javascript:void(0);" wire:click="goToAddProduit" class="btn btn-added">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Nouveau Produit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a href="javascript:void(0);" class="btn btn-searchset">
                            <i data-feather="search" class="feather-search"></i>
                        </a>
                        <div class="dataTables_filter">
                            <label>
                                <input wire:model.live.debounce.300ms='search' type="search" class="form-control form-control-sm" placeholder="Rechercher un produit..." aria-controls="DataTables_Table_0">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table dashboard-expired-products">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>SKU</th>
                            <th>Catégorie</th>
                            <th>Prix Vente</th>
                            <th>Quantité</th>
                            <th class='text-center'>Statut</th>
                            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produits as $produit)
                        <tr>
                            <td>
                                <div class="productimgname">
                                    {{-- BONNE PRATIQUE : Utiliser le Storage pour les images --}}
                                    <img style="width: 40px; height: 40px; object-fit: cover;" 
                                         src="{{ $produit->image_path ? Storage::url($produit->image_path) : asset('assets/img/placeholder.jpg') }}" 
                                         alt="{{ $produit->name }}" class="rounded-circle p-1">
                                    <a href="javascript:void(0);">{{ $produit->name }}</a>
                                </div>
                            </td>
                            <td>{{ $produit->sku }}</td>
                            {{-- BONNE PRATIQUE : Accéder à la relation pour afficher le nom --}}
                            <td>{{ $produit->category->name ?? 'N/A' }}</td>
                            <td>{{ number_format($produit->prix_vente, 2, ',', ' ') }} FCFA</td>
                            <td>{{ $produit->quantity }}</td>
                            <td class="text-center">
                                {{-- Visuellement plus clair qu'une checkbox --}}
                                @if($produit->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td class="action-table-data" style="justify-content: center">
                                <div class="edit-delete-action" style="text-align: center">
                                    <a wire:click="showEditModal({{ $produit->id }})" class="me-2 p-2" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    {{-- Assure-toi que la permission est correcte --}}
                                    @can('supprimer produit') 
                                    <a wire:click="confirmDelete('{{ $produit->name }}', {{ $produit->id }})" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun produit trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $produits->links() }}
            </div>
        </div>
    </div>
    

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
</div>




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
                    @this.deleteproduit(message.data.produit_id);
                }
            });
        } else {
            console.error('Le message ou ses propriétés sont undefined', message);
        }
    });

</script>


