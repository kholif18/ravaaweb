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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('data_service')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('fas fa-icons');
            $table->string('color')->default('#3B82F6');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->integer('services_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
