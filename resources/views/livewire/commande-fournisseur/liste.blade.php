<div>
    <div class="content">
        {{-- 1. EN-TÊTE MIS À JOUR --}}
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Commandes Fournisseurs</h4>
                    <h6>Gérer les bons de commande</h6>
                </div>
            </div>
            <div class="page-btn">
                {{-- Ce bouton appellera la méthode pour afficher le formulaire de création --}}
                <a href="javascript:void(0);" wire:click="goToCreateCommande" class="btn btn-added">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Nouvelle Commande
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="search-set">
                    <div class="search-input">
                         {{-- 2. RECHERCHE ADAPTÉE --}}
                         <input wire:model.live.debounce.300ms="search" type="search" class="form-control form-control-sm" placeholder="Rechercher par réf. ou fournisseur...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            {{-- 3. COLONNES DE LA TABLE MISES À JOUR --}}
                            <tr>
                                <th>Référence</th>
                                <th>Fournisseur</th>
                                <th>Date</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commandes as $commande)
                                <tr wire:key="{{ $commande->id }}">
                                    {{-- 4. AFFICHAGE DES DONNÉES DE LA COMMANDE --}}
                                    <td>{{ $commande->reference }}</td>
                                    <td>{{ $commande->fournisseur->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        {{-- Style conditionnel pour le statut --}}
                                        @if($commande->statut == 'receptionnee')
                                            <span class="badge bg-success">Réceptionnée</span>
                                        @elseif($commande->statut == 'envoyee')
                                            <span class="badge bg-info">Envoyée</span>
                                        @elseif($commande->statut == 'annulee')
                                            <span class="badge bg-danger">Annulée</span>
                                        @else
                                            <span class="badge bg-warning">Brouillon</span>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                                    <td class="action-table-data" style="justify-content: center;">
                                        <div class="edit-delete-action" style="text-align: center">
                                            <a wire:click="goToViewCommande({{ $commande->id }})" class="me-2 p-2" href="javascript:void(0);" title="Voir les détails">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            <a wire:click="goToEditCommande({{ $commande->id }})" class="me-2 p-2" href="javascript:void(0);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </a>
                                            
                                            <a wire:click="deleteCommande({{ $commande->id }})" href="javascript:void(0);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </a>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucune commande trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $commandes->links() }}
                </div>
            </div>
        </div>
    </div>
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
