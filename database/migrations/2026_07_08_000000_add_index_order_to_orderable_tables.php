<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->index('order');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index('order');
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropIndex(['order']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['order']);
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropIndex(['order']);
        });
    }
};
