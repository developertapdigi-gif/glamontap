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
            $table->text('withdraw_reason')->nullable()->after('rating');
            $table->dateTime('withdraw_date')->nullable()->after('withdraw_reason');
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
