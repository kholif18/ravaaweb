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
            $table->unsignedBigInteger('product_id');
            $table->string('sku')->unique()->nullable();
            $table->string('name');
            $table->json('attribute_options')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('product_id');
            $table->index('sku');
            $table->index('is_default');
            $table->index(['discount_start', 'discount_end']);
            
            // Foreign key TANPA nama constraint otomatis
            $table->foreign('product_id', 'fk_product_variants_product')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};