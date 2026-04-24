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
        Schema::create('cms', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->unique();
            $table->string('url_key')->unique();
            $table->longText('page_content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();    
            $table->tinyInteger('status')->default(0)->comment('0 draft,1 Published');    
            $table->unsignedBigInteger('updated_by'); 
            $table->unsignedBigInteger('created_by'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms');
    }
};
