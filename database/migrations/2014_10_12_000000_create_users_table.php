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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse');
            $table->string('sexe');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('mdp');
            $table->string('type');
            $table->unsignedBigInteger('specialite_id')->nullable(); // Nullable foreign key
            $table->foreign('specialite_id')->references('id')->on('specialites')->onDelete('set null'); // Optional cascade delete
            $table->string('cabinet')->nullable()->default(null);
            $table->string('group_sanguin')->nullable()->default(null);
            $table->unsignedBigInteger('medecin_id')->nullable()->default(null);
            $table->unsignedBigInteger('patient_id')->nullable()->default(null);
            $table->foreign('medecin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
