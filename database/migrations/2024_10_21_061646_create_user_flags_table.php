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
        Schema::create('user_flags', function (Blueprint $table) {
            $table->id();           
            $table->unsignedBigInteger('reported_by');  
            $table->unsignedBigInteger('model_id');  
            $table->tinyInteger('type')->comment('1 Post, 2 Job');  
            $table->string('comment')->nullable();  
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_flags');
    }
};
