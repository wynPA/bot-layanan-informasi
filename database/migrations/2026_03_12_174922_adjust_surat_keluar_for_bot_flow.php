<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            
            // 1. Identitas Sesi & Keamanan
            $table->string('session_token')->unique()->nullable();
            $table->enum('status_isi', ['pending', 'completed'])->default('pending');
            $table->string('whatsapp_number')->nullable();
            
            // 2. Data Utama Nomor Surat
            $table->integer('nomor_urut');
            $table->string('nomor_lengkap'); 
            $table->year('tahun'); // Tetap simpan untuk optimasi reset nomor tahunan
            $table->string('kode_surat')->nullable();
            
            // 3. Metadata (Ramping: Tanpa Kolom Judul)
            $table->string('tujuan')->nullable();
            $table->text('perihal')->nullable(); // Menjadi kolom utama informasi surat
            $table->date('tgl_surat')->nullable();

            // 4. Kontrol Waktu & Audit
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};