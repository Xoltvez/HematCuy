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
            $table->boolean('alert_daily_budget')->default(true)->after('daily_alert_sent_at');
            $table->boolean('alert_weekly_report')->default(true)->after('alert_daily_budget');
            $table->boolean('alert_email')->default(false)->after('alert_weekly_report');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alert_daily_budget', 'alert_weekly_report', 'alert_email']);
        });
    }
};
