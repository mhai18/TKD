<?php

use App\Enums\Religion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // New foreign keys
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');

            $table->string('member_id')->unique();
            $table->string('pta_id')->unique()->nullable();
            $table->string('ncc_id')->unique()->nullable();

            $table->date('birth_date');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('civil_status');
            $table->string('belt_level');
            $table->string('religion')->default(Religion::RC->value);

            $table->bigInteger('province_code')->unsigned();
            $table->foreign('province_code')->references('province_code')->on('provinces')->onDelete('cascade');

            $table->bigInteger('municipality_code')->unsigned();
            $table->foreign('municipality_code')->references('municipality_code')->on('municipalities')->onDelete('cascade');

            $table->bigInteger('brgy_code')->unsigned();
            $table->foreign('brgy_code')->references('brgy_code')->on('brgys')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
