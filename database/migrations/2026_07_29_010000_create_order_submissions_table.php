<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // wedding, khitan, baby_name, birthday
            $table->string('customer_name');
            $table->string('whatsapp');
            $table->string('email')->nullable();
            $table->json('data'); // form-specific data
            $table->json('file_path')->nullable(); // foto/attachment
            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_submissions');
    }
};
