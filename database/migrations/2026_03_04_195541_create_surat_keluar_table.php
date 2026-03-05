<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            // Bagian Penomoran
            $table->integer('nomor_urut'); 
            $table->string('nomor_lengkap')->unique();
            $table->year('tahun');
            
            // Bagian Detail Surat
            $table->string('judul')->nullable();
            $table->string('perihal')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->string('tujuan')->nullable();
            
            // Bagian Bot & Status
            $table->string('whatsapp_number'); 
            $table->string('session_token')->nullable(); 
            $table->enum('status_isi', ['pending', 'completed'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
