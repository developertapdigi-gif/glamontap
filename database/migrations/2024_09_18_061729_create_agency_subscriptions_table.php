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
        Schema::create('agency_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agency_id'); 
            $table->unsignedBigInteger('plan_id');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('job_limit')->nullable(); 
            $table->integer('used_job_qty')->nullable();
            $table->integer('tradesman_limit')->nullable(); 
            $table->integer('used_tradesman_qty')->nullable(); 
            $table->tinyInteger('payment_status')->comment('0 Pending,1 Paid');
            $table->tinyInteger('subscription_type')->comment('1 Monthly,2 Yearly');
            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_subscriptions');
    }
};
