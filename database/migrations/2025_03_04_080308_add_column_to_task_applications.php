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
        Schema::table('task_applications', function (Blueprint $table) {
           $table->boolean('is_extended')->nullable()->default(0)->after('status');
           $table->tinyInteger('extended_status')->default(0)->after('is_extended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_applications', function (Blueprint $table) {
            //
        });
    }
};
