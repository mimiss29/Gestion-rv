<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medecin_id');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->enum('statut', ['disponible', 'réservé', 'non disponible'])->default('disponible');
            $table->boolean('est_reserve')->default(false);
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->timestamps();

            // Relations avec les utilisateurs (médecins et patients)
            $table->foreign('medecin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('slots');
    }
}