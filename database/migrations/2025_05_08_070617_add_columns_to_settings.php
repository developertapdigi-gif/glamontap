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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('smtp_host')->nullable()->after('emails');
            $table->integer('smtp_port')->nullable()->after('emails');
            $table->string('smtp_username')->nullable()->after('emails');
            $table->string('smtp_password')->nullable()->after('emails');
            $table->string('smtp_encryption')->nullable()->after('emails');
            $table->string('smtp_from_address')->nullable()->after('emails');
            $table->string('stripe_key')->nullable()->after('emails');      
            $table->string('stripe_secret')->nullable()->after('emails');
            $table->string('stripe_webhook_secret')->nullable()->after('emails');
            $table->string('stripe_currency')->nullable()->after('emails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
