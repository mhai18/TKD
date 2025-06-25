<?php

use App\Enums\TournamentStatus;
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
        Schema::create('pomsae_tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('event_category_id')->nullable()->constrained('event_categories');

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('registration_start');
            $table->date('registration_end');

            $table->string('venue_name')->nullable();

            $table->bigInteger('province_code')->unsigned();
            $table->foreign('province_code')->references('province_code')->on('provinces')->onDelete('cascade');

            $table->bigInteger('municipality_code')->unsigned();
            $table->foreign('municipality_code')->references('municipality_code')->on('municipalities')->onDelete('cascade');

            $table->bigInteger('brgy_code')->unsigned();
            $table->foreign('brgy_code')->references('brgy_code')->on('brgys')->onDelete('cascade');

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->string('status')->default(TournamentStatus::DRAFT->value); // Uses backed enum
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pomsae_tournaments');
    }
};
