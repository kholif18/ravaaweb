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
 *
 * NOTE: Every section is guarded so it is safe on BOTH fresh installs
 * (where the create-table migrations already contain these changes)
 * and upgrades (where some parts were already applied by older runs).
 */
return new class extends Migration
{
    public function up(): void
    {
        // ─── users: login lockout fields ───
        if (!Schema::hasColumn('users', 'login_attempts')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('login_attempts')->default(0)->after('remember_token');
                $table->timestamp('locked_until')->nullable()->after('login_attempts');
            });
        }

        // ─── page_visits: dedup index ───
        if (Schema::hasTable('page_visits') && !Schema::hasIndex('page_visits', 'page_visits_dedup_idx')) {
            Schema::table('page_visits', function (Blueprint $table) {
                $table->index(['page_type', 'ip_address', 'visited_at'], 'page_visits_dedup_idx');
            });
        }

        // ─── nav_links: add parent_id, drop icon (only when table already exists) ───
        if (Schema::hasTable('nav_links')) {
            if (!Schema::hasColumn('nav_links', 'parent_id')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->unsignedBigInteger('parent_id')->nullable()->after('label');
                    $table->foreign('parent_id')->references('id')->on('nav_links')->onDelete('cascade');
                });
            }

            if (Schema::hasColumn('nav_links', 'icon')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->dropColumn('icon');
                });
            }

            if (!Schema::hasIndex('nav_links', 'nav_links_is_active_index')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->index('is_active');
                });
            }

            if (!Schema::hasIndex('nav_links', 'nav_links_sort_order_index')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->index('sort_order');
                });
            }

            if (!Schema::hasIndex('nav_links', 'nav_links_position_index')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->index('position');
                });
            }
        }

        // ─── order_submissions: file_path to JSON (only when table already exists) ───
        if (Schema::hasTable('order_submissions') && Schema::hasColumn('order_submissions', 'file_path')) {
            Schema::table('order_submissions', function (Blueprint $table) {
                $table->json('file_path')->nullable()->change();
            });
        }

        // ─── Performance indexes ───
        $indexes = [
            ['products', 'name'],
            ['services', 'status'],
            ['services', 'is_featured'],
            ['portfolio_items', 'is_featured'],
            ['order_submissions', 'created_at'],
            ['contact_submissions', 'created_at'],
            ['software_house_services', 'is_active'],
            ['software_house_services', 'order'],
        ];

        foreach ($indexes as [$tableName, $column]) {
            if (!Schema::hasTable($tableName) || Schema::hasIndex($tableName, $column)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($column) {
                $table->index($column);
            });
        }
    }

    public function down(): void
    {
        // ─── Performance indexes (reverse) ───
        if (Schema::hasTable('nav_links')) {
            if (Schema::hasIndex('nav_links', 'nav_links_position_index')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->dropIndex(['position']);
                });
            }

            if (Schema::hasIndex('nav_links', 'nav_links_sort_order_index')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->dropIndex(['sort_order']);
                });
            }

            if (Schema::hasIndex('nav_links', 'nav_links_is_active_index')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->dropIndex(['is_active']);
                });
            }
        }

        if (Schema::hasTable('software_house_services')) {
            if (Schema::hasIndex('software_house_services', 'software_house_services_order_index')) {
                Schema::table('software_house_services', function (Blueprint $table) {
                    $table->dropIndex(['order']);
                });
            }

            if (Schema::hasIndex('software_house_services', 'software_house_services_is_active_index')) {
                Schema::table('software_house_services', function (Blueprint $table) {
                    $table->dropIndex(['is_active']);
                });
            }
        }

        if (Schema::hasTable('contact_submissions') && Schema::hasIndex('contact_submissions', 'contact_submissions_created_at_index')) {
            Schema::table('contact_submissions', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        if (Schema::hasTable('order_submissions')) {
            if (Schema::hasIndex('order_submissions', 'order_submissions_created_at_index')) {
                Schema::table('order_submissions', function (Blueprint $table) {
                    $table->dropIndex(['created_at']);
                });
            }
        }

        if (Schema::hasTable('portfolio_items') && Schema::hasIndex('portfolio_items', 'portfolio_items_is_featured_index')) {
            Schema::table('portfolio_items', function (Blueprint $table) {
                $table->dropIndex(['is_featured']);
            });
        }

        if (Schema::hasTable('services')) {
            if (Schema::hasIndex('services', 'services_is_featured_index')) {
                Schema::table('services', function (Blueprint $table) {
                    $table->dropIndex(['is_featured']);
                });
            }

            if (Schema::hasIndex('services', 'services_status_index')) {
                Schema::table('services', function (Blueprint $table) {
                    $table->dropIndex(['status']);
                });
            }
        }

        if (Schema::hasTable('products') && Schema::hasIndex('products', 'products_name_index')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropIndex(['name']);
            });
        }

        // ─── order_submissions: revert JSON to string (only if table exists) ───
        if (Schema::hasTable('order_submissions') && Schema::hasColumn('order_submissions', 'file_path')) {
            Schema::table('order_submissions', function (Blueprint $table) {
                $table->string('file_path')->nullable()->change();
            });
        }

        // ─── nav_links: restore icon, drop parent_id (only if table exists) ───
        if (Schema::hasTable('nav_links')) {
            if (Schema::hasColumn('nav_links', 'parent_id')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->dropForeign(['parent_id']);
                    $table->dropColumn('parent_id');
                });
            }

            if (!Schema::hasColumn('nav_links', 'icon')) {
                Schema::table('nav_links', function (Blueprint $table) {
                    $table->string('icon', 100)->nullable()->after('label');
                });
            }
        }

        // ─── page_visits: drop dedup index ───
        if (Schema::hasTable('page_visits') && Schema::hasIndex('page_visits', 'page_visits_dedup_idx')) {
            Schema::table('page_visits', function (Blueprint $table) {
                $table->dropIndex('page_visits_dedup_idx');
            });
        }

        // ─── users: drop lockout fields ───
        if (Schema::hasColumn('users', 'login_attempts')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['login_attempts', 'locked_until']);
            });
        }
    }
};
