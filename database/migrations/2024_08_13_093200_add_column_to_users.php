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
        Schema::table('users', function (Blueprint $table) {
            $table->string('latitude',20)->nullable()->after('address');
            $table->string('longitude',20)->nullable()->after('latitude');
            $table->string('agency_name')->unique()->nullable()->after('agency_id');
            $table->string('logo')->nullable()->after('agency_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('agency_name');
            $table->dropColumn('logo');

        });
    }
};
