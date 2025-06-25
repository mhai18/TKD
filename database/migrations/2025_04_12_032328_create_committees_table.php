<?php

use App\Enums\Religion;
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
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
