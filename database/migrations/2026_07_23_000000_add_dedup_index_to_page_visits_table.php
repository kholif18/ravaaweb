<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->index(['page_type', 'ip_address', 'visited_at'], 'page_visits_dedup_idx');
        });
    }

    public function down(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropIndex('page_visits_dedup_idx');
        });
    }
};
