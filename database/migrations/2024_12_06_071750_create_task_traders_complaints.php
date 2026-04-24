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
        Schema::create('task_traders_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('trader_id');
            $table->unsignedBigInteger('task_id');
            $table->text('description')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('trader_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_traders_complaints');
    }
};
