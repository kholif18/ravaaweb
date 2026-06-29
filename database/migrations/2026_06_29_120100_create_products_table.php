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
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable(); // JSON: [{title, value}]
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('price_discount', 12, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->datetime('discount_start')->nullable();
            $table->datetime('discount_end')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_service')->default(false);
            $table->text('variant_types')->nullable(); // JSON: [{name:"Ukuran", values:["S","M","L"]}]
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->string('sku')->nullable()->unique();
            $table->string('weight')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->unsignedBigInteger('thumbnail_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_featured']);
            $table->index('category_id');
            $table->index('slug');
            $table->foreign('thumbnail_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
