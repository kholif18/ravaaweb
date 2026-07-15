<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('views_count')->default(0)->after('thumbnail_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->integer('views_count')->default(0)->after('meta_keywords');
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->integer('views_count')->default(0)->after('meta_keywords');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->integer('views_count')->default(0)->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });
    }
};
