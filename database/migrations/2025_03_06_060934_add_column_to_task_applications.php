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
            $table->dateTime('extended_date')->nullable()->after('is_extended');
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
