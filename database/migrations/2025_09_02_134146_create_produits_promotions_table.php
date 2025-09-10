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
        Schema::create('produits_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->timestamps();
            // Pour éviter les doublons (un produit ne peut pas être lié deux fois à la même promo)
            $table->unique(['produit_id', 'promotion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits_promotions');
    }
};
