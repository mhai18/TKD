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
        Schema::create('pomsae_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('pomsae_tournaments')->onDelete('cascade');
            $table->foreignId('player_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('division');
            $table->string('belt_level');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('category'); // Individual, Pair, Team

            $table->string('poomsae_performed')->nullable();
            $table->decimal('accuracy_score', 5, 2)->nullable();
            $table->decimal('presentation_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->nullable();

            $table->timestamp('performance_time')->nullable();
            $table->string('round')->nullable(); // Preliminary, Final etc.

            $table->string('status')->default('Scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pomsae_matches');
    }
};
