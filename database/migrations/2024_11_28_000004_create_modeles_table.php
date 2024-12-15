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
        Schema::create('modeles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marque_id')->constrained('marques')->onDelete('restrict');

            $table->string('nom', 100)->unique();
            $table->timestamps();

            // Contrainte unique pour éviter les doublons
            $table->unique(['marque_id', 'nom'], 'unique_modele_per_marque');

            // Indexation pour améliorer les performances
            $table->index('marque_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeles');
    }
};
