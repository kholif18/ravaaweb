<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('button1_text');
            $table->string('button1_link');
            $table->string('button2_text');
            $table->string('button2_link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default banner
        DB::table('home_banners')->insert([
            'title' => 'Solusi Kreatif untuk Desain, Print & ATK Anda',
            'description' => 'Ravaa Creative menyediakan layanan desain grafis, percetakan, dan alat tulis kantor berkualitas tinggi dengan harga kompetitif. Hasil kreatif yang memukau untuk kebutuhan bisnis Anda.',
            'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'button1_text' => 'Lihat Layanan',
            'button1_link' => '/layanan',
            'button2_text' => 'Portfolio Kami',
            'button2_link' => '/portofolio',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_banners');
    }
};
