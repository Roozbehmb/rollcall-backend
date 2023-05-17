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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->string('title_absence');
            $table->unsignedBigInteger('id_type_absence');
            $table->foreign('id_type_absence')->on('type_absences')->references('id');
            $table->mediumText('description');
            $table->time('time_limitation_request')->nullable();
            $table->tinyInteger('count_day')->nullable();
            $table->time('limitation_leave_time')->nullable();
            $table->tinyInteger('holiday_vacation');
            $table->tinyInteger('show_employees');

            $table->tinyInteger('active')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
