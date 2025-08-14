<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Accueil</h6>
                    <ul>
                        <li >
                            <a href="{{ route('welcome') }}" class="nav-lien {{ setMenuActive('welcome') }}">
                                <i data-feather="home"></i>
                                <span>Tableau de bord</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Gestion(s)</h6>

                    <ul>
                        @can('Chauffeurs')
                        <li>
                            <a href="" class="nav-lien "><i data-feather="user"></i><span>Produits</span>
                            </a>
                        </li>
                        @endcan

                        @can('Usagers')

                        <li><a href="" class="nav-lien "><i data-feather="users"></i><span>Usagers</span></a></li>

                        @endcan

                        @can('Usagers')

                        <li><a href="" class="nav-lien "><i data-feather="dollar-sign"></i><span>Forfaits</span></a></li>

                        @endcan


                        @can('Transactions')

                        <li><a href="" class="nav-lien "><i data-feather="refresh-cw"></i><span>Transactions</span></a></li>

                        @endcan

                        <li><a href="" class="nav-lien "><i data-feather="maximize"></i><span>QR Codes</span></a></li>

                    </ul>
                </li>
               <li class="submenu-open">
                    <h6 class="submenu-hdr">Habilitation</h6>
                    <ul>
                        <li><a href="{{ route('admin.habilitations.users.index') }}" class="nav-lien {{ setMenuActive('admin.habilitations.users.index') }}"><i data-feather="user-check"></i><span>Utilisateur(s)</span></a></li>

                        <li><a href="{{ route('admin.rôle-permission') }}" class="nav-lien {{ setMenuActive('admin.rôle-permission') }}"><i data-feather="shield"></i><span>Rôles & Permission</span></a></li>
                    </ul>
                </li>

                <li class="submenu-open">
                    <h6 class="submenu-hdr">Parametre & support</h6>
                    <ul>
                        <li><a href="{{ route('admin.profil') }}" class="nav-lien {{ setMenuActive('admin.profil') }}"><i data-feather="user-check"></i><span>Profil</span></a></li>

                        <li><a href="" class="nav-lien "><i data-feather="lock"></i><span>Service client</span></a></li>

                        <li><a href="" class="nav-lien "><i data-feather="hard-drive"></i><span>Historique Action</span></a></li>

                        <!--<li><a href="#"><i data-feather="trash"></i><span>Corbeille</span></a></li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
