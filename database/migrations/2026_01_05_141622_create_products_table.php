<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // BASIC INFO
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('main_media_id')->nullable();

            $table->boolean('has_variants')->default(false);
            $table->json('variant_attributes')->nullable();

            // RELATIONS
            $table->foreign('category_id', 'fk_products_categories')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();

            $table->foreign('main_media_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();

            // CONTENT
            $table->text('description')->nullable();
            $table->longText('specifications')->nullable(); // HTML content
            $table->json('tags')->nullable();
            $table->json('quick_infos')->nullable();

            // PRICING (DEFAULT / SINGLE PRODUCT)
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->timestamp('discount_start_at')->nullable();
            $table->timestamp('discount_end_at')->nullable();

            // STOCK STATUS (CATALOG MODE)
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'pre_order'])
                ->default('in_stock');

            // SHIPPING
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('unit')->default('pcs');

            // HIGHLIGHT FLAGS
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_digital')->default(false);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // QUICK INFO (DIRAPIKAN) - duplicate? already above
            // $table->json('quick_infos')->nullable(); 

            // STATUS & TRACKING
            $table->enum('status', ['published', 'draft', 'archived'])
                ->default('draft');

            $table->timestamp('published_at')->nullable();

            $table->integer('view_count')->default(0);
            $table->integer('sold_count')->default(0);
            $table->integer('order_count')->default(0);

            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // INDEXES
            $table->index(['status', 'is_featured']);
            $table->index(['category_id', 'status']);
            $table->index('slug');
            $table->index('sku');
            $table->index('price');
            $table->index('created_at');
            $table->index(['discount_start_at', 'discount_end_at']);
            $table->index('has_variants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};