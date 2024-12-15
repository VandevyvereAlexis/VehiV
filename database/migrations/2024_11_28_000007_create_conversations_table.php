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
        Schema::create('conversations', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('annonce_id')->nullable();
            $table->foreign('annonce_id')->references('id')->on('annonces')->onDelete('set null');
            $table->unsignedBigInteger('acheteur_id')->nullable();
            $table->foreign('acheteur_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('vendeur_id')->nullable();
            $table->foreign('vendeur_id')->references('id')->on('users')->onDelete('set null');

            $table->enum('statut', ['ouverte', 'fermee', 'archivee'])->default('ouverte');
            $table->timestamps();
            $table->softDeletes(); // Ajout de soft deletes

            // Indexation pour améliorer les performances
            $table->index('annonce_id');
            $table->index('acheteur_id');
            $table->index('vendeur_id');

            // Contrainte unique pour éviter les doublons
            $table->unique(['annonce_id', 'acheteur_id', 'vendeur_id'], 'unique_conversation_per_annonce');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
