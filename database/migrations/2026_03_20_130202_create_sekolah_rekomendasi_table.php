<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolah_rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('npsn')->unique()->nullable(); // Nomor Pokok Sekolah Nasional
            $table->enum('jenis', ['Negeri', 'Swasta'])->default('Negeri');
            $table->enum('akreditasi', ['A', 'B', 'C', 'Belum Terakreditasi'])->default('B');
            $table->text('alamat_sekolah');
            $table->string('kecamatan')->nullable();
            $table->string('kota')->default('Batam');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('fasilitas_sekolah')->nullable(); // JSON or comma-separated
            $table->decimal('biaya_spp', 12, 2)->nullable(); // monthly SPP
            $table->decimal('biaya_masuk', 12, 2)->nullable(); // one-time entry fee
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->integer('jumlah_siswa')->nullable();
            $table->integer('jumlah_guru')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah_rekomendasi');
    }
};