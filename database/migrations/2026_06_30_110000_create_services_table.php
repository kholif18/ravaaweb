<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // e.g. fa-solid fa-paint-brush
            $table->foreignId('image_media_id')->nullable()->after('icon')->constrained('media')->nullOnDelete();
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // array of feature strings
            $table->integer('order')->default(0);
            $table->string('status')->default('active'); // active/inactive
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();

            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
