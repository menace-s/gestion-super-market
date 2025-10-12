<div wire:ignore.self>

    @if ($currentPage == PAGECREATEFORM)
            @include('livewire.produit.create')
    @endif

    @if ($currentPage == PAGEEDITFORM)
            @include('livewire.produit.edit')
    @endif

    @if ($currentPage == PAGELIST)
            @include('livewire.produit.liste')
    @endif
    @if($currentPage == PAGEVIEW)
        @include('livewire.produit.views')
    @endif    

</div>
