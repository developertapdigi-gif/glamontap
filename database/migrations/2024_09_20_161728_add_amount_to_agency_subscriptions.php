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
        Schema::table('agency_subscriptions', function (Blueprint $table) {
            $table->decimal('amount',10,2)->after('used_tradesman_qty')->nullable();         
        });
        Schema::table('subscription_plans', function (Blueprint $table) {      
            $table->renameColumn('base_price', 'monthly_price');
            $table->renameColumn('special_price', 'yearly_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agency_subscriptions', function (Blueprint $table) {
            //
        });
    }
};
