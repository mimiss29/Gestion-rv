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
        Schema::create('medecin_salle_de_consultation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medecin_id')->constrained('users');  // Relier à la table users
            $table->foreignId('salle_de_consultation_id')->constrained();  // Relier à la table salles_de_consultation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medecin_salle_de_consultation');
    }
};
