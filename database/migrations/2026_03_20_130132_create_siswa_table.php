<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique(); // Nomor Induk Siswa Nasional
            $table->string('nis')->unique()->nullable(); // Nomor Induk Siswa (lokal)
            $table->string('nama_siswa');
            $table->string('nama_orangtua');
            $table->string('pekerjaan_orangtua')->nullable();
            $table->string('phone_orangtua')->nullable();
            $table->text('alamat');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('kelas')->nullable(); // e.g. "6A", "6B"
            $table->integer('tahun_masuk')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            // Link to user account (for parent login)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};