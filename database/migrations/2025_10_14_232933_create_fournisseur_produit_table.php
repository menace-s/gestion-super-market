<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fournisseur_produit', function (Blueprint $table) {
             $table->primary(['fournisseur_id', 'produit_id']); // Clé primaire composite
            $table->foreignId('fournisseur_id')->constrained()->onDelete('cascade');
            $table->foreignId('produit_id')->constrained()->onDelete('cascade');

            // Nos champs supplémentaires !
            $table->decimal('prix_fournisseur', 10, 2);
            $table->integer('delai_livraison_jours')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseur_produit');
    }
};
