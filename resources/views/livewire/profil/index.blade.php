<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Profil</h4>
            <h6>Profil Utilisateur</h6>
        </div>
    </div>
    <!-- /product list -->
    <div class="card">
        <form wire:submit.prevent="updateProfile" class="row g-4">
        <div class="card-body">
            <div class="profile-set">
                <div class="profile-head">

                </div>
                <div class="profile-top">
                    <div class="profile-content">
                        <div class="profile-contentimg">
                            <img src="{{ asset('assets/icon/1.png') }}" alt="img" id="blah">
                            <div class="profileupload">
                                <input type="file" id="imgInp">
                                <a href="javascript:void(0);" ><img src="assets/img/icons/edit-set.svg"  alt="img"></a>
                            </div>
                        </div>
                        <div class="profile-contentname">
                            <h2>{{ userFullName() }}</h2>
                            <h4>Mise à jour de vos données personnelles.</h4>
                        </div>
                    </div>
                    <!-- <div class="ms-auto">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Save</a>
                        <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                    </div> -->
                </div>
            </div>

                <div class="row">
                    <form wire:submit.prevent="updateProfile" class="row g-4">
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks">
                            <label class="form-label">Nom & Prénom</label>
                            <input wire:model="name" type="text" class="form-control" >
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks">
                            <label class="form-label">Role</label>
                            <input wire:model="role" type="text" class="form-control" >
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks">
                            <label>Adresse e-mail</label>
                            <input type="email" class="form-control" wire:model='email'>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks">
                            <label class="form-label">Numéro de téléphone</label>
                            <input type="text" wire:model="phone" >
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks">
                            <label class="form-label">Genre</label>

                            <div class="pass-group">
                                <select class="form-control" wire:model='genre' name="genre" id="genre">
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                                </select>
                                @error('genre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks">
                            <label class="form-label">Mot de passe</label>

                            <div class="pass-group">
                                <input placeholder="***********" wire:model='password' type="password" class="pass-input form-control">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-submit me-2">Modifier</button>
                    </div>

        </div>
        </form>
    </div>
    <!-- /product list -->
</div>



<script>
    window.addEventListener("showSuccessMessage", event=>{

            Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Profil modifié avec succès!",
            showConfirmButton: false,
            timer: 3000
            })
    })

</script>
