<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nav_links', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('label');
            $table->foreign('parent_id')->references('id')->on('nav_links')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('nav_links', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
