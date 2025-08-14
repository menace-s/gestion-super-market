<?php


namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilComp extends Component
{
    public $name;
    public $username;
    public $email;
    public $phone;
    public $password;
    public $user;

    public $genre;

    public $utilisateur;

    public function mount()
    {
        $this->user = Auth::user(); // Récupérer l'utilisateur connecté
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->utilisateur = $this->user->utilisateur;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone; // Assurez-vous que ce champ existe
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8', // Mot de passe facultatif
        ]);

        // Mise à jour des informations de l'utilisateur
        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'genre' => $this->genre,
            'utilisateur' => $this->utilisateur,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        // Mise à jour du mot de passe uniquement si un nouveau mot de passe est fourni
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        // Notification de succès
        $this->dispatch("showSuccessMessage", ["message" => "Profil modifié avec succès!"]);
    }

    public function render()
    {
        return view('livewire.profil.index')
            ->extends('layouts.app')
            ->section('content');
    }
}
