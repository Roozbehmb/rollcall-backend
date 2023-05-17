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
        Schema::create('shift_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();;
            $table->unsignedBigInteger('id_absents')->nullable();;
            $table->unsignedBigInteger('id_week_shift')->nullable();;
            $table->unsignedBigInteger('id_shift_dailies')->nullable();;
            $table->unsignedBigInteger('id_periodic_shift')->nullable();;
            $table->unsignedBigInteger('id_dedicated_shift')->nullable();;
            $table->unsignedBigInteger('id_day')->nullable();;

            $table->foreign('id_user')->on('users')->references('id');
            $table->foreign('id_absents')->on('absences')->references('id');
            $table->foreign('id_periodic_shift')->on('periodic_shifts')->references('id');
            $table->foreign('id_dedicated_shift')->on('shift_dailies')->references('id');
            $table->foreign('id_shift_dailies')->on('shift_dailies')->references('id');
            $table->foreign('id_day')->on('days_week')->references('id');
            $table->foreign('id_week_shift')->on('weekly_shifts')->references('id');

            $table->string('shift_dailies_date_up')->nullable();;
            $table->string('shift_dailies_date_at')->nullable();;

            $table->string('periodic_shifts_date_up')->nullable();;
            $table->string('periodic_shifts_date_at')->nullable();;

            $table->string('week_shifts_date_up')->nullable();;
            $table->string('week_shifts_date_at')->nullable();;

            $table->string('dedicated_shifts_date_up')->nullable();;
            $table->string('dedicated_shifts_date_at')->nullable();;


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_employees');
    }
};
