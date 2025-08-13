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
        Schema::create('packs_chat_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_expediteur')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_destinataire')->constrained('users')->onDelete('cascade');
            $table->text('contenu');
            $table->dateTime('date_envoi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packs_chat_message');
    }
};
