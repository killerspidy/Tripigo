<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // Consolidation: A single JSON field for all specific available dates
            $table->json('available_dates')->nullable()->after('friday_date');
            
            // Cleanup: Removing fields that are now redundant
            if (Schema::hasColumn('tours', 'available_from')) {
                $table->dropColumn(['available_from', 'available_to', 'blocked_dates']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('available_dates');
            $table->date('available_from')->nullable()->after('friday_date');
            $table->date('available_to')->nullable()->after('available_from');
            $table->json('blocked_dates')->nullable()->after('available_to');
        });
    }
};
