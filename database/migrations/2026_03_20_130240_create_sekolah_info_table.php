<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Stores editable information about BIIS itself (the school being served).
     * Admin can update this via the settings panel.
     */
    public function up(): void
    {
        Schema::create('sekolah_info', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('Batam Integrated Islamic School');
            $table->string('singkatan')->default('BIIS');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('sejarah')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('npsn')->nullable();
            $table->string('nss')->nullable();
            $table->text('alamat');
            $table->string('kota')->default('Batam');
            $table->string('provinsi')->default('Kepulauan Riau');
            $table->string('kode_pos')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('foto_sekolah')->nullable();
            $table->enum('akreditasi', ['A', 'B', 'C', 'Belum'])->default('A');
            $table->text('fasilitas')->nullable(); // JSON list
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah_info');
    }
};