<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');

            $table->string('chapter_name');
            $table->date('date_started');

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
        Schema::dropIfExists('chapters');
    }
};
