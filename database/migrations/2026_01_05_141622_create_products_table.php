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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            
            // Tambahkan column untuk varian
            $table->boolean('has_variants')->default(false);
            $table->json('variant_attributes')->nullable();
            
            // Tambahkan column untuk diskon dengan tanggal
            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            
            $table->foreign('category_id', 'fk_products_categories')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->decimal('cost_price', 15, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimum_stock')->default(10);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'pre_order', 'backorder'])->default('in_stock');
            $table->boolean('manage_stock')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('unit')->default('pcs');
            $table->json('tags')->nullable();
            $table->json('colors')->nullable();
            $table->json('sizes')->nullable();
            $table->json('images')->nullable();
            $table->string('main_image')->nullable();
            $table->text('specifications')->nullable();
            $table->text('features')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->text('warranty_info')->nullable();
            $table->enum('status', ['published', 'draft', 'archived'])->default('draft');
            $table->integer('view_count')->default(0);
            $table->integer('sold_count')->default(0);
            $table->integer('order_count')->default(0);
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'is_featured']);
            $table->index(['category_id', 'status']);
            $table->index(['sku', 'barcode']);
            $table->index('slug');
            $table->index('price');
            $table->index('created_at');
            $table->index(['discount_start', 'discount_end']);
            $table->index('has_variants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};