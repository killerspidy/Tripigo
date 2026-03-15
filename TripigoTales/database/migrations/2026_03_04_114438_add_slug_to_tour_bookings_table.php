<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
        });

        // Backfill existing bookings with unique slugs
        $bookings = DB::table('tour_bookings')->whereNull('slug')->get();
        foreach ($bookings as $booking) {
            $date = Carbon::parse($booking->created_at)->format('Ymd');
            $slug = 'TT-' . $date . '-' . strtoupper(Str::random(5));

            // Ensure uniqueness
            while (DB::table('tour_bookings')->where('slug', $slug)->exists()) {
                $slug = 'TT-' . $date . '-' . strtoupper(Str::random(5));
            }

            DB::table('tour_bookings')->where('id', $booking->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
