<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria');        // e.g. "Biaya SPP", "Akreditasi", "Lokasi"
            $table->string('kode_kriteria')->unique(); // e.g. "C1", "C2", "C3"
            $table->enum('jenis', ['benefit', 'cost']);
            // 'benefit' = higher is better (akreditasi, fasilitas)
            // 'cost'    = lower is better (biaya, jarak)
            $table->decimal('bobot', 5, 4);         // weight 0.0000–1.0000, must sum to 1
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);  // display order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};