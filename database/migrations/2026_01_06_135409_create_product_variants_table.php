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
            $table->timestamp('discount_start_at')->nullable();
            $table->timestamp('discount_end_at')->nullable();
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'pre_order'])->default('in_stock');
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('unit')->default('pcs');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('product_id');
            $table->index('sku');
            $table->index('is_default');

            // Foreign key TANPA nama constraint otomatis
            $table->foreign('product_id', 'fk_product_variants_product')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreign('image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};