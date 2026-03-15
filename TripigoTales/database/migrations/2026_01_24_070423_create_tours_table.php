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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            // Basic
            $table->string('title');
            $table->string('location')->nullable();
            $table->tinyInteger('star_rating')->nullable();
            $table->string('image')->nullable();
            $table->string('pdf')->nullable();
            $table->boolean('status')->default(0);

            // Category
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();

            // Price
            $table->decimal('price',10,2)->nullable();
            $table->decimal('two_person_share',10,2)->nullable();
            $table->decimal('three_person_share',10,2)->nullable();

            // Details
            $table->integer('day')->nullable();
            $table->integer('max_people')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('bedroom')->nullable();
            $table->date('friday_date')->nullable();
            $table->string('pickup')->nullable();
            $table->time('departure_time')->nullable();

            // Text
            $table->text('description')->nullable();
            $table->text('what_to_expect')->nullable();

            // JSON fields
            $table->json('price_includes')->nullable();
            $table->json('departure_return_location')->nullable();
            $table->json('travel_plan')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
