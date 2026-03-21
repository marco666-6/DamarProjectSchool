<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->string('nama_kegiatan');
            $table->enum('jenis_kegiatan', [
                'Akademik',
                'Non-Akademik',
                'Ekstrakurikuler',
                'Keagamaan',
                'Sosial',
                'Tahfidz',
                'Lainnya'
            ])->default('Lainnya');
            $table->date('tanggal_kegiatan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('prestasi')->nullable(); // e.g. "Juara 1", "Peserta"
            $table->string('tingkat')->nullable(); // e.g. "Sekolah", "Kota", "Provinsi", "Nasional"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};