<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Consolidated migration — merges all individual "add/alter" migrations
 * from 2026_07_20 through 2026_07_31 into a single file.
 *
 * Replaces:
 *   2026_07_20_163317_add_login_lockout_to_users_table
 *   2026_07_23_000000_add_dedup_index_to_page_visits_table
 *   2026_07_28_205633_add_parent_id_to_nav_links_table
 *   2026_07_28_214725_drop_icon_from_nav_links_table
 *   2026_07_29_020000_update_order_submissions_file_path_to_json
 *   2026_07_31_010000_add_performance_indexes
 */
return new class extends Migration
{
    public function up(): void
    {
        // ─── users: login lockout fields ───
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('login_attempts')->default(0)->after('remember_token');
            $table->timestamp('locked_until')->nullable()->after('login_attempts');
        });

        // ─── page_visits: dedup index ───
        Schema::table('page_visits', function (Blueprint $table) {
            $table->index(['page_type', 'ip_address', 'visited_at'], 'page_visits_dedup_idx');
        });

        // ─── nav_links: add parent_id, drop icon ───
        Schema::table('nav_links', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('label');
            $table->foreign('parent_id')->references('id')->on('nav_links')->onDelete('cascade');
            $table->dropColumn('icon');
        });

        // ─── order_submissions: file_path to JSON ───
        Schema::table('order_submissions', function (Blueprint $table) {
            $table->json('file_path')->nullable()->change();
        });

        // ─── Performance indexes ───
        Schema::table('products', function (Blueprint $table) {
            $table->index('name');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_featured');
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->index('is_featured');
        });

        Schema::table('order_submissions', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('software_house_services', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('order');
        });

        Schema::table('nav_links', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('sort_order');
            $table->index('position');
        });
    }

    public function down(): void
    {
        // ─── Performance indexes (reverse) ───
        Schema::table('nav_links', function (Blueprint $table) {
            $table->dropIndex(['position']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('software_house_services', function (Blueprint $table) {
            $table->dropIndex(['order']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('order_submissions', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        // ─── order_submissions: revert JSON to string ───
        Schema::table('order_submissions', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
        });

        // ─── nav_links: restore icon, drop parent_id ───
        Schema::table('nav_links', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->string('icon', 100)->nullable()->after('label');
        });

        // ─── page_visits: drop dedup index ───
        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropIndex('page_visits_dedup_idx');
        });

        // ─── users: drop lockout fields ───
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_attempts', 'locked_until']);
        });
    }
};
