<div wire:ignore.self>

    @if ($currentPage == PAGECREATEFORM)
            @include('livewire.categorie.create')
    @endif

    @if ($currentPage == PAGEEDITFORM)
            @include('livewire.categorie.edit')
    @endif

    @if ($currentPage == PAGELIST)
             @include('livewire.categorie.liste')
    @endif
    @if($currentPage == PAGEVIEW)
        @include('livewire.categorie.views')
    @endif    

</div>
