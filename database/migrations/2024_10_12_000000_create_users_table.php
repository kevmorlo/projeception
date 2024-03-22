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
            $table->string('name', 15);
            $table->string('email', 39)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name', 39)->nullable();
            $table->string('last_name', 39)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('description', 2000)->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->unsignedBigInteger('role_id')->default("1");
            $table->foreignId('category_id')->cascadeOnDelete()->nullable()->constrained();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->boolean('is_banned')->default(false);
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
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
