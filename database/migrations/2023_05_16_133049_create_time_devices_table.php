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
        Schema::create('time_devices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('id_model_device');
            $table->foreign('id_model_device')->on('model_devices')->references('id');
            $table->string('ip');
            $table->string('port');
            $table->string('submask');
            $table->string('gateway');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_device');
    }
};
