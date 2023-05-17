<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('weekly_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('id_shift_work')->nullable();
            $table->unsignedBigInteger('id_days_week')->nullable();
            $table->unsignedBigInteger('id_alternate_shift')->nullable();
            $table->tinyInteger('general_shift')->nullable();
            $table->tinyInteger('alternate_shift')->nullable();


            $table->foreign('id_shift_work')->on('shift_dailies')->references('id');
            $table->foreign('id_days_week')->on('days_week')->references('id');
            $table->foreign('id_alternate_shift')->on('shift_dailies')->references('id');
            $table->tinyInteger('active')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_shifts');
    }
};
