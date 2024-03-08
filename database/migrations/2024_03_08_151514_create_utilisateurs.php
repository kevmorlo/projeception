<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Représente la table "utilisateurs" de la base de données
 * @see Utilisateur
 */
class CreateUtilisateursTable extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('pseudonyme', 15);
            $table->string('mail', 39)->unique();
            $table->longText('mdp');
            $table->string('nom', 39)->nullable();
            $table->string('prenom', 39)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('est_banni')->default(0);
            $table->unsignedBigInteger('Statuts_id')->default(1);
            $table->unsignedBigInteger('Categories_id')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('Statuts_id')->references('id')->on('statuts')->onDelete('no action')->onUpdate('no action');
            $table->foreign('Categories_id')->references('id')->on('categories')->onDelete('no action')->onUpdate('no action');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
}
