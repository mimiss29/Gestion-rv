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
        Schema::create('rendezvouses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medecin_id'); 
            $table->unsignedBigInteger('patient_id');
            $table->date('date'); 
            $table->time('heure'); 
            $table->string('lieu'); 
            $table->string('status'); 
            $table->foreign('medecin_id') ->references('id') ->on('users') ->onDelete('cascade');
             $table->foreign('patient_id') ->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendezvouses');
    }
};
