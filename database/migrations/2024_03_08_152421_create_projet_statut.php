<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatutProjetsTable extends Migration
{

    public function up(): void
    {
        Schema::create('statut_projets', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statut_projets');
    }
}