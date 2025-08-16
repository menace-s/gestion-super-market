<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Liste des Clients</h4>
                <h6>Clients</h6>
            </div>
        </div>
        <div class="page-btn">
            <a wire:click="goToAddUser" class="btn btn-added"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>Nouveau Client</a>
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
        <div class="card-body" style="height: 700px; max-height:700px;">
            <div class="table-responsive dataview" >
                <table class="table dashboard-expired-products">
                    <thead>
                        <tr>
                            <th>Nom & prénom</th>
                            <th>Contact name</th>
                            <th>Contact</th>
                            <th>Adresse</th>
                            <th>Adresse e-mail</th>
                            <th>Ajouté</th>
                            <th >Statut</th>
                            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <td>
                                <div class="productimgname">
                                    <img style="width: 30px" src="{{ asset('assets/icon/1.png') }}" width="70" class="rounded-circle p-1">
                                    <a href="javascript:void(0);">ddddddd</a>
                                </div>
                            </td>
                            <td><span class="badge bg-success">ddddddd</span></td>
                            <td>ddddddd</td>
                            <td>ddddddd</td>
                            <td>ddddddd</td>
                            <td>ddddddd</td>
                            <td>fffff</td>
                            <td class="action-table-data" style="justify-content: center">
                                <div class="edit-delete-action" style="text-align: center">
                                    <a  class="me-2 p-2" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    @can('Supprimer un utilisateur')


                                    <a>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
         <div class="dataTables_paginate paging_simple_numbers pb-3 pt-4" id="DataTables_Table_0_paginate">
            <ul class="pagination">
                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">

                </li>
            </ul>
        </div>
    </div>
    <!-- /product list -->



     <!-- Modal d'ajout -->
     <div wire:ignore.self class="modal fade" id="FormModalAdd" tabindex="-1" aria-labelledby="FormModalLabelAdd" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FormModalLabelAdd">Ajouter un utilisateur</h5>
                    <button type="button" class="btn-close" wire:click="closeModals" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <form  wire:submit.prevent="addUser">
                            <div class="mb-3">
                                <input placeholder="Nom & prenom" type="text" class="form-control" id="name" wire:model="name" >
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <input placeholder="Adrsse e-mail"  type="email" class="form-control" id="email" wire:model="email" >
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <input placeholder="Numéro de téléphone"  type="text" class="form-control"  wire:model="phone" >
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <select class="form-control" wire:model="role_id" id="role_id" required>
                                    <option value="">Sélectionner un rôle</option>

                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Ajouter</button>

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
                    <h5 class="modal-title" id="FormModalLabelEdit">Modifier l'utilisateur</h5>
                    <button type="button" class="btn-close" wire:click="closeModals" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  wire:submit.prevent="updateUser">
                        <div class="mb-3">
                            <input placeholder="Nom & prenom" type="text" class="form-control" id="name" wire:model="name" >
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <input placeholder="Adrsse e-mail"  type="email" class="form-control" id="email" wire:model="email" >
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <input placeholder="Numéro de téléphone"  type="text" class="form-control"  wire:model="phone" >
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <select class="form-control" wire:model="role_id" id="role_id" required>
                                <option value="">Sélectionner un rôle</option>

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Modifier</button>

                    </form>
                </div>
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
                    @this.deleteUser(message.data.user_id);
                }
            });
        } else {
            console.error('Le message ou ses propriétés sont undefined', message);
        }
    });

</script>

