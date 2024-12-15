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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('marque_id')->nullable()->constrained('marques')->onDelete('restrict');
            $table->foreignId('modele_id')->nullable()->constrained('modeles')->onDelete('restrict');

            $table->string('titre', 150);
            $table->boolean('vendu')->default(false);
            $table->boolean('visible')->default(true);
            $table->boolean('premiere_main')->default(false);
            $table->decimal('prix', 9, 2);
            $table->integer('kilometrage');
            $table->integer('puissance_fiscale');
            $table->integer('puissance_din');
            $table->date('premiere_mise_en_circulation');
            $table->string('ville', 100);
            $table->char('code_postal', 5);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('description');
            $table->enum('carburant', [
                'essence',
                'diesel',
                'hybride',
                'electrique',
                'gpl',
                'gaz_naturel_cgn',
                'autre',
            ])->default('essence');
            $table->enum('boite', [
                'automatique',
                'manuelle',
            ])->default('automatique');
            $table->enum('type', [
                '4x4_suv_crossover',
                'Citadine',
                'berline',
                'break',
                'cabriolet',
                'coupé',
                'monospace_minibus',
                'commerciale_société',
                'sans_permis',
                'autre',
            ])->default('4x4_suv_crossover');
            $table->enum('porte', [
                '3_portes',
                '4_portes',
                '5_portes',
                '6_portes_ou_plus',
            ])->default('5_portes');
            $table->enum('place', [
                '1_place',
                '2_places',
                '3_places',
                '4_places',
                '5_places',
                '6_places',
                '7_ou_plus',
            ])->default('5_places');
            $table->enum('couleur', [
                'blanc',
                'noir',
                'gris',
                'argent',
                'bleu',
                'rouge',
                'vert',
                'marron',
                'beige',
                'jaune',
                'autre',
            ])->default('blanc');
            $table->enum('etat', [
                'sans_frais_a_prevoir',
                'roulante_reparation_a_prevoir',
                'non_roulante',
                'accidentee',
                'pour_pieces',
            ])->default('sans_frais_a_prevoir');
            $table->enum('crit_air', [
                'crit_air_1',
                'crit_air_2',
                'crit_air_3',
                'crit_air_4',
                'crit_air_5',
                'non_classe',
            ])->default('crit_air_1');
            $table->enum('classe_emission', [
                'euro_1',
                'euro_2',
                'euro_3',
                'euro_4',
                'euro_5',
                'euro_6',
            ])->default('euro_6');
            $table->timestamps();
            $table->softDeletes(); // Ajout de soft deletes

            // Contrainte unique pour éviter les doublons
            $table->unique([
                'user_id',
                'marque_id',
                'modele_id',
                'kilometrage',
                'premiere_mise_en_circulation',
                'prix'
                ],'unique_annonce_par_vehicule');

            // Indexation pour améliorer les performances
            $table->index(['ville', 'code_postal']);
            $table->index(['latitude', 'longitude']);
            $table->index('prix');
            $table->index('created_at');
            $table->index(['marque_id', 'modele_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
