<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nav_links', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }

    public function down(): void
    {
        Schema::table('nav_links', function (Blueprint $table) {
            $table->string('icon', 100)->nullable()->after('label');
        });
    }
};
