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
        Schema::create('messages', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamp('last_message_at')->nullable();
            $table->boolean('lu')->default(false);
            $table->text('message', 2000)->nullable(false);
            $table->timestamps();
            $table->softDeletes(); // Ajout de soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
