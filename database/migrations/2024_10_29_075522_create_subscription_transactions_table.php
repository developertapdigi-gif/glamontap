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
        Schema::create('subscription_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id'); 
            $table->unsignedBigInteger('subscription_id'); 
            $table->unsignedBigInteger('agency_id'); 
            $table->string('transaction_id'); 
            $table->text('additional_information')->nullable(); 
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('agency_subscriptions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_transactions');
    }
};
