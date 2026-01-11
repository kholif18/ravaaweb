<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama file asli tanpa ekstensi
            $table->string('filename'); // Nama file unik dengan timestamp
            $table->string('original_name'); // Nama file asli lengkap
            $table->string('mime_type'); // Mime type file
            $table->string('extension', 10); // Ekstensi file
            $table->unsignedBigInteger('size')->default(0); // Ukuran file dalam bytes
            $table->string('path')->default('media'); // Path relatif (selalu 'media')
            $table->string('thumbnail_path')->nullable(); // Path thumbnail
            $table->string('alt_text')->nullable(); // Alt text untuk SEO
            $table->text('description')->nullable(); // Deskripsi opsional
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->json('metadata')->nullable(); // Metadata tambahan (dimensions, colors, etc)
            $table->unsignedBigInteger('usage_count')->default(0); // Hitung berapa kali digunakan
            $table->unsignedBigInteger('uploaded_by')->nullable(); // ID user yang upload
            
            // Foreign key untuk uploaded_by
            $table->foreign('uploaded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            // Index untuk pencarian
            $table->index('name');
            $table->index('filename');
            $table->index(['status', 'created_at']);
            $table->index('usage_count');
            
            $table->timestamps();
            $table->softDeletes(); // Untuk soft delete
        });

        // Tabel pivot untuk hubungan many-to-many media usage
        Schema::create('media_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id');
            $table->string('model_type'); // Model yang menggunakan media (contoh: App\Models\Post)
            $table->unsignedBigInteger('model_id'); // ID dari model
            $table->string('field_name'); // Nama field di model
            $table->string('purpose')->nullable(); // Tujuan penggunaan (featured, gallery, etc)
            
            // Foreign keys
            $table->foreign('media_id')
                  ->references('id')
                  ->on('media')
                  ->onDelete('cascade');
            
            // Index untuk performa
            $table->index(['model_type', 'model_id']);
            $table->index(['media_id', 'model_type']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_usages');
        Schema::dropIfExists('media');
    }
};