<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // User preferences stored as JSON
            $table->json('preferensi');
            // SAW result stored as JSON array of {sekolah_id, skor_total, ranking, detail}
            $table->json('hasil_saw')->nullable();
            $table->decimal('skor_total', 8, 4)->nullable(); // top result score
            $table->integer('ranking')->nullable(); // top result rank
            $table->enum('status_rekomendasi', ['pending', 'selesai', 'expired'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};