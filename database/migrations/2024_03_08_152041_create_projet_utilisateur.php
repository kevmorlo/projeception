<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('projet_utilisateur', function (Blueprint $table) {
            $table->unsignedBigInteger('utilisateurs_id');
            $table->unsignedBigInteger('projets_id');
            $table->unsignedBigInteger('statut_projet_id');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('utilisateurs_id')->references('id')->on('utilisateurs')->onDelete('no action')->onUpdate('no action');
            $table->foreign('projets_id')->references('id')->on('projets')->onDelete('no action')->onUpdate('no action');
            $table->foreign('statut_projet_id')->references('id')->on('statut_projets')->onDelete('no action')->onUpdate('no action');

            // Clé primaire composite
            $table->primary(['utilisateurs_id', 'projets_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_utilisateur');
    }
};

