<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // 'weekly'  → runs on specific day(s) of the week every week
            // 'specific'→ runs only on admin-defined specific dates
            // 'open'    → customer picks any future date
            $table->enum('schedule_type', ['weekly', 'specific', 'open'])
                  ->default('weekly')
                  ->after('available_dates');

            // For 'weekly' mode: days of week as integers (0=Sun, 1=Mon, ... 6=Sat)
            // e.g. [5] = every Friday, [6, 0] = every Sat & Sun
            $table->json('schedule_days')->nullable()->after('schedule_type');

            // For 'specific' mode: list of exact YYYY-MM-DD dates that are enabled
            $table->json('specific_dates')->nullable()->after('schedule_days');
        });

        // Migrate existing tours: keep them working as Friday-only (day 5)
        DB::table('tours')->update([
            'schedule_type' => 'weekly',
            'schedule_days' => json_encode([5]), // Friday
        ]);
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['schedule_type', 'schedule_days', 'specific_dates']);
        });
    }
};
