<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('projet_utilisateur', function (Blueprint $table) {
            $table->unsignedBigInteger('Utilisateur_id');
            $table->unsignedBigInteger('Projet_id');
            $table->unsignedBigInteger('Statut_projet_id');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('Utilisateur_id')->references('id')->on('utilisateurs')->onDelete('no action')->onUpdate('no action');
            $table->foreign('Projet_id')->references('id')->on('projets')->onDelete('no action')->onUpdate('no action');
            $table->foreign('Statut_projet_id')->references('id')->on('statut_projets')->onDelete('no action')->onUpdate('no action');

            // Clé primaire composite
            $table->primary(['Utilisateur_id', 'Projet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_utilisateur');
    }
};

