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
        Schema::create('photos', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade');

            $table->string('url', 2048);
            $table->string('format', 10)->nullable();
            $table->unsignedInteger('position')->default(0); // Ordre d'affichage
            $table->boolean('principale')->default(false);   // Photo principale
            $table->enum('type', ['exterieur', 'interieur'])->nullable();
            $table->timestamps();
            $table->softDeletes(); // Ajout de soft deletes

            // Contrainte unique pour éviter les doublons
            $table->unique(['annonce_id', 'position'], 'unique_position_per_annonce');
            $table->unique(['annonce_id', 'principale'], 'unique_principale_per_annonce');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
