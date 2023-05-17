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
        Schema::create('traffics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_absents')->nullable();
            $table->unsignedBigInteger('id_substitute')->nullable();
            $table->unsignedBigInteger('id_mission')->nullable();
            $table->unsignedBigInteger('id_day')->nullable();


            $table->tinyInteger('time_day_absents')->nullable();
            $table->string('description_absents')->nullable();
            $table->date('data_absents')->nullable();

            $table->tinyInteger('time_day_mission')->nullable();
            $table->string('description_mission')->nullable();
            $table->date('data_mission')->nullable();

            $table->Time('enter_time')->nullable();
            $table->Time('exit_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();



            $table->timestamps();

            $table->foreign('id_day')->on('days_week')->references('id');
            $table->foreign('id_user')->on('users')->references('id');
            $table->foreign('id_absents')->on('absences')->references('id');
            $table->foreign('id_substitute')->on('shift_dailies')->references('id');
            $table->foreign('id_mission')->on('missions')->references('id');

            $table->tinyInteger('active')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffics');
    }
};
