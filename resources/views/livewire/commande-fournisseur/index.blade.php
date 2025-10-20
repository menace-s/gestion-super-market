<div wire:ignore.self>
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
                <a href="javascript:void(0);" wire:click="create" class="btn btn-added">
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
                                <th class="text-end">Total</th>
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
                                    <td class="text-center">
                                        {{-- On ajoutera les boutons de modification et suppression ici --}}
                                        <a href="#" class="me-3 p-2" title="Voir les détails">
                                            <i data-feather="eye"></i>
                                        </a>
                                        <a href="#" class="me-3 p-2" title="Modifier">
                                            <i data-feather="edit"></i>
                                        </a>
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
</div>