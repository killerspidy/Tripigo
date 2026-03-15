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
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->string('from_date')->nullable()->change();
            $table->string('to_date')->nullable()->change();
            $table->integer('days')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->string('from_date')->nullable(false)->change();
            $table->string('to_date')->nullable(false)->change();
            $table->integer('days')->nullable(false)->change();
        });
    }
};
