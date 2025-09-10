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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediteur');
            $table->unsignedBigInteger('id_destinataire');
            $table->text('contenu');
            $table->boolean('lu')->default(false);
            $table->timestamp('date_envoi')->useCurrent();

            $table->foreign('id_expediteur')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_destinataire')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
