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
                    <h6 class="submenu-hdr">Gestion du stock </h6>

                    <ul>
                        @can('Chauffeurs')
                        <li>
                            <a href="{{route('admin.produit')}}" class="nav-lien {{ setMenuActive('admin.produit') }}"><i data-feather="box"></i><span>Produits</span>
                            </a>
                        </li>
                        @endcan

                        @can('Usagers')

                        <li><a href="{{route('admin.categorie')}}" class="nav-lien {{ setMenuActive('admin.categorie') }}"><i data-feather="layers"></i><span>Catégories</span></a></li>

                        @endcan

                        @can('Usagers')

                        <li><a href="{{route('admin.mouvement_stock')}}" class="nav-lien {{ setMenuActive('admin.mouvement_stock') }}"><i data-feather="repeat"></i><span>Mouvements de stock</span></a></li>

                        @endcan


                        @can('Transactions')

                        <li><a href="{{route("admin.inventaire")}}" class="nav-lien {{ setMenuActive('admin.inventaire') }}"><i data-feather="clipboard"></i><span>Inventaires</span></a></li>

                        @endcan


                    </ul>
                </li>

                <li class="submenu-open">
                    <h6 class="submenu-hdr">Gestion des partenaires</h6>

                    <ul>
                        @can('Chauffeurs')
                        <li>
                            <a href="{{route("admin.fournisseur")}}" class="nav-lien {{ setMenuActive('admin.fournisseur') }}"><i data-feather="truck"></i><span>Fournisseurs</span>
                            </a>
                        </li>
                        @endcan

                        @can('Usagers')

                        <li><a href="{{route("admin.client")}}" class="nav-lien {{ setMenuActive('admin.client') }} "><i data-feather="shopping-bag"></i><span>Clients</span></a></li>

                        @endcan

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
