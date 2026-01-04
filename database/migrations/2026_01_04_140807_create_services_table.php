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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('features')->nullable(); // JSON atau text untuk fitur-fitur
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_unit')->default('project'); // project, hour, month, etc
            $table->integer('duration')->nullable(); // Durasi dalam hari
            $table->string('duration_unit')->default('days'); // days, weeks, months
            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->integer('order')->default(0);
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // Array gambar
            $table->text('notes')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('category_id');
            $table->index('is_active');
            $table->index('is_popular');
            $table->index('slug');
            $table->index(['category_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
