<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Accueil</h6>
                    <ul>
                        {{-- Lien vers le tableau de bord principal --}}
                        <li class="{{ setMenuActive('welcome') }}">
                            <a href="{{ route('welcome') }}">
                                <i data-feather="home"></i><span>Tableau de bord</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- SECTION GESTION DU STOCK --}}
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Gestion du Stock</h6>
                    <ul>
                        @can('voir produits')
                        <li class="{{ setMenuActive('admin.stock.produits.index') }}">
                            <a href="{{ route('admin.stock.produits.index') }}">
                                <i data-feather="box"></i><span>Produits</span>
                            </a>
                        </li>
                        @endcan

                        @can('gérer catégories')
                        <li class="{{ setMenuActive('admin.stock.categories.index') }}">
                            <a href="{{ route('admin.stock.categories.index') }}">
                                <i data-feather="layers"></i><span>Catégories</span>
                            </a>
                        </li>
                        @endcan

                        @can('gérer commandes fournisseurs')
                        <li class="{{ setMenuActive('admin.stock.commandes.index') }}">
                            <a href="{{ route('admin.stock.commandes.index') }}"><i data-feather="shopping-cart"></i><span>Commandes</span></a>
                        </li>
                        @endcan
                        
                        @can('gérer inventaires')
                        <li class="{{ setMenuActive('admin.stock.mouvements.index') }}">
                            <a href="{{ route('admin.stock.mouvements.index') }}">
                                <i data-feather="repeat"></i><span>Mouvements de stock</span>
                            </a>
                        </li>
                        @endcan

                        @can('gérer inventaires')
                        <li class="{{ setMenuActive('admin.stock.inventaires.index') }}">
                            <a href="{{ route('admin.stock.inventaires.index') }}">
                                <i data-feather="clipboard"></i><span>Inventaires</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>

                {{-- SECTION PARTENAIRES --}}
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Gestion des partenaires</h6>
                    <ul>
                        @can('gérer fournisseurs')
                        <li class="{{ setMenuActive('admin.stock.fournisseurs.index') }}">
                            <a href="{{ route('admin.stock.fournisseurs.index') }}">
                                <i data-feather="truck"></i><span>Fournisseurs</span>
                            </a>
                        </li>
                        @endcan

                        @can('gérer clients')
                        <li class="{{ setMenuActive('admin.clients.index') }}">
                            <a href="{{ route('admin.clients.index') }}">
                                <i data-feather="shopping-bag"></i><span>Clients</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>

                {{-- SECTION ADMINISTRATION (Visible uniquement par les admins) --}}
                @canany(['gérer utilisateurs', 'gérer rôles et permissions'])
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Administration</h6>
                    <ul>
                        @can('gérer utilisateurs')
                        <li class="{{ setMenuActive('admin.administration.users.index') }}">
                            <a href="{{ route('admin.administration.users.index') }}">
                                <i data-feather="users"></i><span>Utilisateurs</span>
                            </a>
                        </li>
                        @endcan

                        @can('gérer rôles et permissions')
                        <li class="{{ setMenuActive('admin.administration.roles.index') }}">
                            <a href="{{ route('admin.administration.roles.index') }}">
                                <i data-feather="shield"></i><span>Rôles & Permissions</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                {{-- SECTION PARAMÈTRES --}}
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Paramètres & Support</h6>
                    <ul>
                        <li class="{{ setMenuActive('admin.profil') }}">
                            <a href="{{ route('admin.profil') }}">
                                <i data-feather="user"></i><span>Mon Profil</span>
                            </a>
                        </li>
                        {{-- Autres liens --}}
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>