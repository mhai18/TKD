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
        Schema::create('kyorugi_tournament_matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')->constrained('kyorugi_tournaments')->onDelete('cascade');

            // Match grouping fields
            $table->string('division');
            $table->string('weight_class');
            $table->string('belt_level');
            $table->enum('gender', ['Male', 'Female']);

            // Participants (nullable for walkovers/byes)
            $table->foreignId('player_red_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('player_blue_id')->nullable()->constrained('users')->onDelete('set null');

            // Winner (can be red, blue, or null if not yet done)
            $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');

            // Match status and metadata
            $table->string('round')->nullable(); // Example: "Quarterfinal", "Semifinal", "Final"
            $table->string('match_status')->default('Scheduled'); // Scheduled, Completed, Forfeit, etc.

            $table->timestamp('match_datetime')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyorugi_tournament_matches');
    }
};
