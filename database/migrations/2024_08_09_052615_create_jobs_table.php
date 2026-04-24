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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('agency_id');
            $table->string('location')->nullable();            
            $table->string('latitude',20)->nullable();
            $table->string('longitude',20)->nullable();
            $table->tinyInteger('experiance_range')->nullable();       
            $table->integer('number_of_employees')->nullable();
            $table->integer('skill_category')->nullable();
            $table->decimal('minimum_price',10,2)->nullable();
            $table->decimal('maximum_price',10,2)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('image')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 Pending,1 Accepted,3 Rejected');
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
