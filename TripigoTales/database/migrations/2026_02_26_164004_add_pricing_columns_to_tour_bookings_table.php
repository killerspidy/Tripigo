<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('addons_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->decimal('gst_amount', 10, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->dropForeign(['tour_bookings_coupon_id_foreign']);
            $table->dropColumn(['subtotal', 'addons_amount', 'discount_amount', 'coupon_id', 'gst_amount']);
        });
    }
};
