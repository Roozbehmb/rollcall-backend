<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('periodic_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('course_length');
            $table->unsignedBigInteger('id_shift_work_dailies');
            $table->foreign('id_shift_work_dailies')->on('shift_dailies')->references('id');
            $table->time('min_shift_work')->nullable();
            $table->time('max_shift_work')->nullable();
            $table->unsignedBigInteger('id_course_type');
            $table->foreign('id_course_type')->on('course_types')->references('id');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('periodic_shifts');
    }
};
