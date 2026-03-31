<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            
            // 1. RELASI POLYMORPHIC (Paling Penting)
            // Ini akan menciptakan kolom archivable_id dan archivable_type
            $table->morphs('archivable'); 

            // 2. METADATA DASAR
            $table->string('judul_arsip'); // Diambil otomatis saat pemindahan
            $table->string('kategori')->nullable(); // Pilihan: Keuangan, Kepegawaian, dll.
            
            // 3. LOKASI FISIK (The Physical Map)
            $table->string('no_rak')->nullable();
            $table->string('no_box')->nullable();
            $table->string('no_sampul')->nullable();
            
            // 4. AUTOMASI RETENSI (Khusus Keuangan)
            $table->date('tgl_pemusnahan')->nullable(); 
            
            // 5. AUDIT TRAIL
            $table->timestamps(); // created_at = Tgl Masuk Arsip, updated_at = Tgl Perubahan Lokasi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
