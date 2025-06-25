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
        Schema::create('pomsae_tournament_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('pomsae_tournaments')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');

            $table->string('division');
            $table->string('belt_level');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('category'); // Individual, Pair, Team

            $table->foreignId('registered_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pomsae_tournament_players');
    }
};
