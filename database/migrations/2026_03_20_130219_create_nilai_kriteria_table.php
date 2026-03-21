<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * This table stores the raw score for each school on each criterion.
     * The SAW engine reads this table to perform:
     *   1. Normalization
     *   2. Weighted scoring
     *   3. Ranking
     */
    public function up(): void
    {
        Schema::create('nilai_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolah_rekomendasi')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('nilai', 15, 4); // raw numeric score for this school on this criterion
            $table->text('keterangan')->nullable(); // e.g. "Rp 500.000/bulan", "A (95 poin)"
            $table->timestamps();

            $table->unique(['sekolah_id', 'kriteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_kriteria');
    }
};