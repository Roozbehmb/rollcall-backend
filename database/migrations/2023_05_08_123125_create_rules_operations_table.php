<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rules_operations', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->time('time_right_leave')->default(null);

            $table->time('time_max_overtime')->default(null);

            $table->time('time_working_holiday')->default(null);

            $table->time('time_working_Friday')->default(null);

            $table->tinyInteger('traffic_time_time_limit')->default(null);
            $table->tinyInteger('time_limit_forgotten')->default(null);
            $table->tinyInteger('time_limit_forgotten_confirm')->default(null);
            $table->tinyInteger('forgotten_traffic_count');
            $table->tinyInteger('time_forgotten_traffic_count')->default(null);
            $table->tinyInteger('overtime_overlap');
            $table->tinyInteger('overcalculation');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules_operations');
    }
};
