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
        Schema::create('home_feeds', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('type')->comment('1 Job,2 Post');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');   
            $table->foreign('job_id')->references('id')->on('tasks')->onDelete('cascade');   
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_feeds');
    }
};
