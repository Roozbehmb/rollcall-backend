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
        Schema::create('set_absents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_listEmployees');
            $table->unsignedBigInteger('id_absence');
            $table->foreign('id_listEmployees')->on('users')->references('id');
            $table->foreign('id_absence')->on('absences')->references('id');
            $table->date('date');
            $table->tinyInteger('days');
            $table->mediumText('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_absents');
    }
};
