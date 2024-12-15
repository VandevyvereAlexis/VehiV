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
        Schema::create('etats_conversation', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->enum('statut', ['visible', 'supprimee'])->default('visible');
            $table->timestamps();

            // Contrainte unique pour éviter les doublons
            $table->unique(['conversation_id', 'user_id'], 'unique_user_conversation');

            // Indexation pour améliorer les performances
            $table->index('conversation_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etats_conversation');
    }
};
