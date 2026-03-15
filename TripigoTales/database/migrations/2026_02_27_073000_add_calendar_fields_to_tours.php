<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // Date range the tour is available for booking
            $table->date('available_from')->nullable()->after('friday_date');
            $table->date('available_to')->nullable()->after('available_from');
            // JSON array of specific blocked dates e.g. ["2026-03-14", "2026-04-01"]
            $table->json('blocked_dates')->nullable()->after('available_to');
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['available_from', 'available_to', 'blocked_dates']);
        });
    }
};
