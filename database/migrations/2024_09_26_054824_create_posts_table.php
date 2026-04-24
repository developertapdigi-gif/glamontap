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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->string('location');
            $table->string('short_description')->nullable();
            $table->text('content');
            $table->string('thumb_url')->nullable();
            $table->integer('skill_id')->nullable();            
            $table->tinyInteger('post_type')->default(0)->comment('image,video');
            $table->tinyInteger('status')->default(0);
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
