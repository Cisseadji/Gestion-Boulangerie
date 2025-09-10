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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_client')->constrained('users')->onDelete('cascade');
            $table->dateTime('date_commande');
            $table->enum('statut', ['EN_PREPARATION', 'PRETE', 'EN_LIVRAISON', 'LIVREE']);
            $table->enum('mode_paiement', ['EN_LIGNE', 'A_LA_LIVRAISON']);
            $table->decimal('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
