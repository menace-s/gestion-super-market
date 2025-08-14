

<div wire:ignore.self>

    @if ($currentPage == PAGEPERMISSION)
            @include('livewire.permissions.permission')
    @endif

    @if ($currentPage == PAGEROLE)
            @include('livewire.permissions.role')
    @endif


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
                @this.deleteRole(message.data.role_id);
            }
        });
    } else {
        console.error('Le message ou ses propriétés sont undefined', message);
    }
});

</script>

