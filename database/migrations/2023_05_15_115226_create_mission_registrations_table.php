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
        Schema::create('mission_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->unsignedBigInteger('mission_id');
            $table->foreign('mission_id')->on('missions')->references('id');
            $table->tinyInteger('periodic_time');
            $table->string('date')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_registrations');
    }
};
