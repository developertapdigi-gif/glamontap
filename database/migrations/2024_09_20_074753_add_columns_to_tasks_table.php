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
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('company_address')->nullable()->after('agency_id');
            $table->string('company_latitude')->unique()->nullable()->after('company_address');
            $table->string('company_longitude')->unique()->nullable()->after('company_latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('company_address');
            $table->dropColumn('company_latitude');
            $table->dropColumn('company_longitude');
        });
    }
};
