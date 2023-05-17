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
        Schema::create('assign_working_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('rule_id')->nullable();;
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('rule_id')->on('rules_operations')->references('id');
            $table->string('from')->nullable();
            $table->string('from_to')->nullable();
            $table->tinyInteger('active')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_working_rules');
    }
};
