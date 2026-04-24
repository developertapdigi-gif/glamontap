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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();          
            $table->text('description')->nullable();            
            $table->decimal('base_price',8,2)->nullable(); 
            $table->decimal('special_price',8,2)->nullable(); 
            $table->integer('job_limit')->nullable(); 
            $table->integer('tradesman_limit')->nullable(); 
            $table->integer('duration')->nullable(); 
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
