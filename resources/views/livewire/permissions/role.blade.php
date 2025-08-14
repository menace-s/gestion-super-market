<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Rôles et autorisations</h4>
                <h6>Gestion rôle</h6>
            </div>
        </div>
        <div class="page-btn">
            <a wire:click='goToAddRole()' class="btn btn-added"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>Nouveau rôle</a>
        </div>
    </div>

    <!-- /product list -->
    <div class="card">
        <div class="card-header">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a href="javascript:void(0);" class="btn btn-searchset">
                            <i data-feather="search" class="feather-search"></i>
                        </a>
                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                        <label>
                            <input wire:model.live='search' type="search" class="form-control form-control-sm" placeholder="Recherche" aria-controls="DataTables_Table_0">
                        </label>
                    </div>
                </div>
                </div>


            </div>
        </div>
        <div class="card-body" style="height: 500px; max-height:500px;">
            <div class="table-responsive dataview" >
                <table class="table dashboard-expired-products">
                    <thead>
                        <tr>
                            <th>Nom du rôle</th>
                            <th>Ajouté</th>
                            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at->diffForHumans() }}</td>
                            <td class="action-table-data" style="justify-content: center">
                                <div class="edit-delete-action">

                                    @can('Modifier un rôle')
                                    <a wire:click="goToEditRole({{ $role->id }})" class="me-2 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    @endcan


                                    @can('Attribution rôle')
                                    <a class="p-2 me-2" wire:click='goToPermission({{ $role->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                    </a>
                                    @endcan

                                    @can('Supprimer un rôle')
                                    <a wire:click="confirmDelete('{{ $role->name }}', {{ $role->id }})" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
        <div class="dataTables_paginate paging_simple_numbers mb-2 px-3" id="DataTables_Table_0_paginate">
            {{ $roles->links() }}
        </div>
    </div>
    <!-- /product list -->
</div>




  <!-- Modal d'ajout -->
  <div wire:ignore.self class="modal fade" id="FormModalAdd" tabindex="-1" aria-labelledby="FormModalLabelAdd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FormModalLabelAdd">Ajouter un nouveau rôle</h5>
                <button type="button" class="btn-close" wire:click="closeModals" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <form  wire:submit.prevent="addRole">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom du rôle</label>
                            <input type="text" class="form-control" id="name" wire:model="name" >
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>

                    </form>
                </div>
        </div>
    </div>
</div>

<!-- Modal d'édition -->
<div wire:ignore.self class="modal fade" id="FormModalEdit" tabindex="-1" aria-labelledby="FormModalLabelEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FormModalLabelEdit">Modifier le rôle</h5>
                <button type="button" class="btn-close" wire:click="closeModals" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateRole">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du rôle</label>
                        <input type="text" class="form-control" id="name" wire:model="name" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
