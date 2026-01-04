<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->unique(); // 1, 2, 3, 4
            $table->string('icon')->default('bi-paint-bucket');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('position');
            $table->index('is_active');
        });

        // Insert default data
        DB::table('homepage_categories')->insert([
            [
                'position' => 1,
                'icon' => 'bi-paint-bucket',
                'title' => 'Desain Grafis',
                'description' => 'Logo, brosur, banner, kartu nama, dan desain kreatif lainnya untuk bisnis Anda.',
                'is_active' => true
            ],
            [
                'position' => 2,
                'icon' => 'bi-printer',
                'title' => 'Percetakan',
                'description' => 'Cetak offset dan digital dengan kualitas tinggi untuk segala kebutuhan percetakan.',
                'is_active' => true
            ],
            [
                'position' => 3,
                'icon' => 'bi-pen',
                'title' => 'Alat Tulis Kantor',
                'description' => 'Berbagai kebutuhan ATK dengan kualitas terbaik untuk mendukung produktivitas.',
                'is_active' => true
            ],
            [
                'position' => 4,
                'icon' => 'bi-tshirt',
                'title' => 'Sablon & Merchandise',
                'description' => 'Sablon kaos, mug, tumbler, dan merchandise custom untuk branding perusahaan.',
                'is_active' => true
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_categories');
    }
};