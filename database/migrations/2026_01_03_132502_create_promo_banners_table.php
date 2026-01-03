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
        Schema::create('promo_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->json('benefits')->nullable(); // Store as JSON array
            $table->string('cta_text');
            $table->string('whatsapp_number');
            $table->string('phone_number')->nullable();
            $table->string('color')->default('primary');
            $table->string('image_url')->nullable();
            $table->date('start_date');
            $table->date('expiry_date');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_banners');
    }
};
