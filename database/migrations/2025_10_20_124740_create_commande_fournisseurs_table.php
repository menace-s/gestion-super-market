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
        Schema::create('commande_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fournisseur_id')->constrained()->onDelete('cascade');
            $table->string('reference')->unique(); // Ex: CMD-2025-001
            $table->date('date_commande');
            $table->enum('statut', ['brouillon', 'envoyee', 'receptionnee', 'annulee'])->default('brouillon');
            $table->decimal('total', 12, 2)->nullable(); // Le montant total de la commande
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_fournisseurs');
    }
};
