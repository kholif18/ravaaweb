<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('page_type', 50);                // home, product, service, portfolio, software_house, contact, detail_product, detail_portfolio
            $table->unsignedBigInteger('page_id')->nullable(); // FK ke produk/layanan/portfolio yg dikunjungi
            $table->string('url', 500);
            $table->string('title', 255)->nullable();        // judul halaman untuk referensi
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('visited_at')->useCurrent();
            $table->index('page_type');
            $table->index('visited_at');
            $table->index(['page_type', 'page_id']);
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
