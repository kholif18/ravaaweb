<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->foreignId('image_media_id')->nullable()->after('image')->constrained('media')->nullOnDelete();
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->foreignId('image_media_id')->nullable()->after('image')->constrained('media')->nullOnDelete();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('image_media_id')->nullable()->after('icon')->constrained('media')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropForeign(['image_media_id']);
            $table->dropColumn('image_media_id');
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropForeign(['image_media_id']);
            $table->dropColumn('image_media_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['image_media_id']);
            $table->dropColumn('image_media_id');
        });
    }
};
