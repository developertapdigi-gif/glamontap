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
        Schema::create('plans_addons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 Disable, 1 Enable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans_addons');
    }
};
