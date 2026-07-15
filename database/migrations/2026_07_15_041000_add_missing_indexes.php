<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables/columns that still need indexes (checked via SHOW INDEX).
     */
    public function up(): void
    {
        // Banners — missing is_active
        Schema::table('banners', function (Blueprint $table) {
            $table->index('is_active');
        });

        // Portfolio Items — missing status, slug (plain)
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->index('status');
            $table->index('slug');
        });

        // Testimonials — missing status, order
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('status');
            $table->index('order');
        });

        // Contact Submissions — missing status
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->index('status');
        });

        // Page Visits — missing ip_address
        Schema::table('page_visits', function (Blueprint $table) {
            $table->index('ip_address');
        });

        // Product Variants — missing is_active
        Schema::table('product_variants', function (Blueprint $table) {
            $table->index('is_active');
        });

        // Footer Links — missing is_active
        Schema::table('footer_links', function (Blueprint $table) {
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['slug']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['order']);
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropIndex(['ip_address']);
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('footer_links', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });
    }
};
