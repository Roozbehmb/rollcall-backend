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
        Schema::create('periodic_shift_departments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('general_shift');
            $table->tinyInteger('id_periodic_shift');
            $table->tinyInteger('start_period');
            $table->tinyInteger('end_period');
            $table->tinyInteger('rest_period');
            $table->tinyInteger('shift');
            $table->tinyInteger('holiday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodic_shift_departments');
    }
};
