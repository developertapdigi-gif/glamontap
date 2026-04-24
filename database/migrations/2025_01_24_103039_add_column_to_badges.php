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
        Schema::table('badges', function (Blueprint $table) {
            $table->string('class_name')->default(1)->comment('1 junior,2 experience,3 intermediate,4 expert,5 brown,6 green')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badges', function (Blueprint $table) {
            //
        });
    }
};
