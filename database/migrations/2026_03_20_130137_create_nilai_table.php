<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->string('semester'); // e.g. "Ganjil 2024/2025"
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_ujian', 5, 2)->nullable();
            $table->decimal('nilai_praktikum', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable(); // auto-calculated or manual
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Unique: one grade per student per subject per semester
            $table->unique(['siswa_id', 'mapel_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};