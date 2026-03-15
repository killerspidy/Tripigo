<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addon_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('addon_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->unique(['addon_id', 'tour_id']);
            $table->timestamps();
        });

        // Migrate existing tour_id data from addons table into the pivot table
        if (Schema::hasColumn('addons', 'tour_id')) {
            \Illuminate\Support\Facades\DB::statement('
                INSERT INTO addon_tour (addon_id, tour_id, created_at, updated_at)
                SELECT id, tour_id, NOW(), NOW()
                FROM addons
                WHERE tour_id IS NOT NULL
            ');

            // Drop the old tour_id column
            Schema::table('addons', function (Blueprint $table) {
                $table->dropForeign(['tour_id']);
                $table->dropColumn('tour_id');
            });
        }
    }

    public function down(): void
    {
        // Re-add tour_id column before dropping the pivot table
        if (!Schema::hasColumn('addons', 'tour_id')) {
            Schema::table('addons', function (Blueprint $table) {
                $table->foreignId('tour_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
        Schema::dropIfExists('addon_tour');
    }
};
