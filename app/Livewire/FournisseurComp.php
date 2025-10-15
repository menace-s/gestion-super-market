<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Fournisseur;
use Illuminate\Validation\Rule;

class FournisseurComp extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form
    public $name, $email, $phone;

    protected $listeners = [
    'deleteFournisseur' => 'handleDeleteFournisseur', // v2 (emit)
];

    // Recherche + édition
    public $search = '';
    public $editUserId = null;

    // États modales
    public $visibilieModaleAdd  = false;
    public $visibilieModaleEdit = false;

    protected function rules(): array
    {
        $id = $this->editUserId ?? null;

        return [
            'name'  => ['required','string','max:255'],
            'email' => ['nullable','email', Rule::unique('fournisseurs','email')->ignore($id)],
            'phone' => ['nullable','string','max:20', Rule::unique('fournisseurs','phone')->ignore($id)],
        ];
    }

    public function updatedSearch(){ $this->resetPage(); }

    private function resetForm(): void
    {
        $this->name = $this->email = $this->phone = null;
        $this->editUserId = null;
    }

    // ===== AJOUT =====
    public function goToAddUser(): void
    {
        $this->resetForm();
        $this->visibilieModaleAdd = true;
        $this->dispatch('show-add-modal');
    }

    public function addUser(): void
    {
        $this->validate();

        Fournisseur::create([
            'name'         => $this->name,
            'email'        => $this->email,
            'phone'        => $this->phone,
            // colonnes présentes dans ta DB
            'contact_name' => null,
            'adress'       => null, // orthographe utilisée ailleurs dans le projet
        ]);

        $this->dispatch('showSuccessMessage', message: 'Fournisseur ajouté avec succès!');
        $this->closeModals();
        $this->resetForm();
        $this->resetPage();
    }

    // ===== MODIFICATION =====
    public function goToEditUser(int $id): void
    {
        $f = Fournisseur::findOrFail($id);
        $this->editUserId = $f->id;

        $this->name  = $f->name;
        $this->email = $f->email;
        $this->phone = $f->phone;

        $this->visibilieModaleEdit = true;
        $this->dispatch('show-edit-modal');
    }

    public function updateUser(): void
    {
        $this->validate();

        $f = Fournisseur::findOrFail($this->editUserId);
        $f->update([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->dispatch('showSuccessMessage', message: 'Fournisseur mis à jour avec succès!');
        $this->closeModals();
        $this->resetForm();
    }

    // ===== SUPPRESSION =====
   public function confirmDelete(int $id): void
{
    $f = \App\Models\Fournisseur::findOrFail($id);

    $this->dispatch('showConfirmMessage', message: [
        'title' => 'Êtes-vous sûr de continuer ?',
        'text'  => "Vous êtes sur le point de supprimer {$f->name} de la liste des fournisseurs. Voulez-vous continuer ?",
        'type'  => 'warning',
        'id'    => $id,
    ]);
}



   #[On('deleteFournisseur')] // v3
public function handleDeleteFournisseur($id = null): void
{
    // v3 => array {id: 5}, v2 => entier 5
    if (is_array($id)) {
        $id = $id['id'] ?? $id['Fournisseur_id'] ?? null;
    }
    if (!$id) return;

    \App\Models\Fournisseur::whereKey((int) $id)->delete();

    $this->dispatch('showSuccessMessage', message: 'Fournisseur supprimé avec succès!');

    // ✅ Evite l'accès à $this->page : on revient proprement à la page 1
    $this->resetPage();
}



    public function deleteFournisseur($payload): void
    {
        // En v3, Livewire.dispatch('deleteFournisseur', { id }) envoie un array associatif

        
        $id = is_array($payload) && isset($payload['id']) ? (int)$payload['id'] : (int)$payload;

        Fournisseur::whereKey($id)->delete();

        $this->dispatch('showSuccessMessage', message: 'Fournisseur supprimé avec succès!');

        // UX: si la page devient vide, reculer d'une page
        if ($this->page > 1 && $this->currentPageResultsCount() === 0) {
            $this->previousPage();
        }
    }

    private function currentPageResultsCount(): int
    {
        $term = trim($this->search);
        $q = Fournisseur::query();
        if ($term !== '') {
            $like = "%{$term}%";
            $q->where(function ($x) use ($like) {
                $x->where('name','like',$like)
                  ->orWhere('email','like',$like)
                  ->orWhere('phone','like',$like)
                  ->orWhere('adress','like',$like);
            });
        }
        return $q->orderByDesc('id')->paginate(10, ['*'], 'page', $this->page)->count();
    }

    public function closeModals(): void
    {
        $this->visibilieModaleAdd  = false;
        $this->visibilieModaleEdit = false;
        $this->dispatch('close-modals');
    }

    public function render()
    {
        $search = '%'.trim($this->search).'%';

        $fournisseurs = Fournisseur::where('name','like',$search)
            ->orWhere('email','like',$search)
            ->orWhere('phone','like',$search)
            ->orWhere('adress','like',$search)
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.fournisseur.index', compact('fournisseurs'))
            ->extends('layouts.app')->section('content');
    }
}
