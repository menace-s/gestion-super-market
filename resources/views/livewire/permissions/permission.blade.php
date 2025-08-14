<div wire:poll.2s class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Permissions</h4>
                <h6>Gérer vos autorisations</h6>
            </div>
        </div>
    </div>
    <!-- /product list -->
    <div class="card table-list-card">
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all" wire:click="selectAllPermissions">
                                    <span class="checkmarks"></span>
                                </label>
                                
                            </th>
                            <th>Nom permission</th>
                            <th>Ajouté</th>
                            <th>Assigné</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolePermissions['permissions'] as $index => $permission)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" wire:model="rolePermissions.permissions.{{ $index }}.active">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>{{ $permission['permission_name'] }}</td>
                            <td>{{ $permission['created_at']->diffForHumans() }}</td>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" wire:model="rolePermissions.permissions.{{ $index }}.active">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="btn btn-primary mt-3" wire:click="updateRolePermissions">Enregistrer les permissions</button>

                <button class="btn btn-secondary mt-3" wire:click="goToListRole()">Annuler</button>


            </div>
        </div>
    </div>
    <!-- /product list -->
</div>
