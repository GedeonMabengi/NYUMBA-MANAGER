<?php
// database/migrations/2024_01_01_000004_create_bailleur_avocat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bailleur_avocat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bailleur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('avocat_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['bailleur_id', 'avocat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bailleur_avocat');
    }
};