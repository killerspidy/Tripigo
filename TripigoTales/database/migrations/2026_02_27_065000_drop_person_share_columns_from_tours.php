<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'two_person_share')) {
                $table->dropColumn('two_person_share');
            }
            if (Schema::hasColumn('tours', 'three_person_share')) {
                $table->dropColumn('three_person_share');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->decimal('two_person_share', 10, 2)->nullable()->after('price');
            $table->decimal('three_person_share', 10, 2)->nullable()->after('two_person_share');
        });
    }
};
