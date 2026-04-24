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
        Schema::create('agency_subscription_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('agency_subscription_id');
            $table->unsignedBigInteger('addon_id')->nullable();
            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agency_subscription_id')->references('id')->on('agency_subscriptions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_subscription_addons');
    }
};
