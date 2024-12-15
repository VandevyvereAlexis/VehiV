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
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('role_id')->default(1)->constrained('roles')->onDelete('restrict');

            // Statut de l'utilisateur
            $table->enum('status', ['actif', 'inactif', 'banni'])->default('actif');

            // Vérification des informations utilisateur
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            // Informations personnelles de base
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('pseudo', 50)->unique();
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->char('phone', 10)->unique()->nullable();

            // Gestion des utilisateurs bannis
            $table->timestamp('banni_at')->nullable();
            $table->text('raison_ban')->nullable();

            $table->string('image', 255)->default('default.jpg');
            $table->rememberToken();
            $table->timestamps();

            // Soft deletes pour marquer un utilisateur comme supprimé sans effacer ses données
            $table->softDeletes();
        });




        // Gère les demandes de réinitialisation de mot de passe
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 255)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // Date d'expiration du jeton
        });




        // Suivi connexions des utilisateurs
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Supprimé en cascade si l'utilisateur est supprimé
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
