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
        Schema::create('assign_missions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mission');
            $table->foreign('id_mission')->on('missions')->references('id');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->on('users')->references('id');
            $table->time('start_time');
            $table->time('end_time');
            $table->dateTime('date');
            $table->string('description');
            $table->tinyInteger('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_missions');
    }
};
