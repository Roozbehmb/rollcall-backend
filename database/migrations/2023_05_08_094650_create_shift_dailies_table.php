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
        Schema::create('shift_dailies', function (Blueprint $table) {
            $table->id();
            $table->string('title');


            $table->time('shift_rest_conditions_rest_period')->nullable();
            $table->time('shift_rest_conditions_minimum_Second_rest_period')->nullable();
            $table->time('shift_rest_conditions_second_rest_period')->nullable();

            $table->time('watch_enter_time')->nullable();
            $table->time('watch_exit_time')->nullable();
            $table->time('watch_rest_time')->nullable();
            $table->time('watch_second_enter_time')->nullable();
            $table->time('watch_second_exit_time')->nullable();
            $table->time('watch_duration_of_attendance')->nullable();

            $table->time('min_overtime')->nullable();
            $table->time('max_overtime')->nullable();



            $table->time('subject_work_holiday_min_downtime')->nullable();
            $table->time('subject_work_holiday_max_downtime')->nullable();

            $table->time('min_time_friday_work')->nullable();
            $table->time('max_time_friday_work')->nullable();

            $table->tinyInteger('subject_to_fines');
            $table->tinyInteger('holidays_not_counted');
            $table->tinyInteger('manager_forgiveness');
            $table->tinyInteger('calculation_of_forgiveness_time');
            $table->time('forgiveness_time_limit')->nullable();
            $table->unsignedBigInteger('determining_basis_fine')->nullable();


            $table->time('start_night_work')->nullable();
            $table->time('end_night_work')->nullable();

            $table->time('min_work')->nullable();
            $table->time('max_work')->nullable();
            $table->unsignedBigInteger('turn_shift_work_id')->nullable();
            $table->foreign('turn_shift_work_id')->on('turn_work_shift')->references('id');

            $table->tinyInteger('registration_attendance')->nullable();
            $table->tinyInteger('shift_general')->nullable();
            $table->tinyInteger('active')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_work_dailies');
    }
};
