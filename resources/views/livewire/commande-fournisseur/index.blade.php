<div wire:ignore.self>

    @if ($currentPage == PAGECREATEFORM)
            @include('livewire.commande-fournisseur.create')
    @endif

    @if ($currentPage == PAGEEDITFORM)
            @include('livewire.commande-fournisseur.edit')
    @endif

    @if ($currentPage == PAGELIST)
            @include('livewire.commande-fournisseur.liste')
    @endif
    @if($currentPage == PAGEVIEW)
        @include('livewire.commande-fournisseur.view')
    @endif    

</div>