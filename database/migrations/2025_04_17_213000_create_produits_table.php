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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->integer('quantite')->default(0);
            $table->decimal('prix', 10, 2); // 10 chiffres au total, 2 décimales
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['disponible', 'indisponible', 'en_rupture'])->default('disponible');
            $table->string('image')->nullable();
            $table->softDeletes(); // Pour la suppression logique
            $table->timestamps();
            
            // Index pour optimiser les recherches
            $table->index('nom');
            $table->index('categorie_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};