<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->text('attributes')->nullable(); // JSON: {"Ukuran":"S","Warna":"Hijau"}
            $table->string('sku')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->decimal('price_discount', 12, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->datetime('discount_start')->nullable();
            $table->datetime('discount_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_service')->default(false);
            $table->string('weight')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('image')->nullable(); // path to variant image
            $table->timestamps();

            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
