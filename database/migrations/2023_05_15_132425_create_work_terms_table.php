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
        Schema::create('work_terms', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_month')->nullable();
            $table->tinyInteger('calculation_one_month')->nullable();
            $table->tinyInteger('calculation_desired_interval')->nullable();
            $table->dateTime('from')->nullable();
            $table->dateTime('from_to')->nullable();
            $table->tinyInteger('basis_overtime_limit_holiday_working_friday')->nullable();
            $table->timestamps();
            $table->foreign('id_user')->on('users')->references('id');
            $table->foreign('id_month')->on('months')->references('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_terms');
    }
};
