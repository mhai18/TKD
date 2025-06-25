<?php

use App\Enums\PlayerStatus;
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
        Schema::create('kyorugi_tournament_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('kyorugi_tournaments')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');

            $table->string('division');
            $table->string('weight_class');
            $table->string('belt_level');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('status')->default(PlayerStatus::APPROVED->value);

            $table->foreignId('registered_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyorugi_tournament_players');
    }
};
