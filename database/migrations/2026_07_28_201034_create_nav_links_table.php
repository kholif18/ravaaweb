<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nav_links', function (Blueprint $table) {
            $table->id();
            $table->string('label', 255);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('url', 500);
            $table->enum('position', ['navbar', 'mobile', 'both'])->default('both')->comment('Where to display this link');
            $table->enum('target', ['_self', '_blank'])->default('_self');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('nav_links')->onDelete('cascade');
            $table->index('is_active');
            $table->index('sort_order');
            $table->index('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nav_links');
    }
};
