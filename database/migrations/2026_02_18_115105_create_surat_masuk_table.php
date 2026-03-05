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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_hp_pengirim');
            $table->string('nama_file_utama');
            $table->string('path_file');
            $table->string('group_id_wa')->nullable();
            $table->string('status')->default('BELUM'); // Kita sesuaikan defaultnya
            $table->string('kategori')->default('Lainnya'); // Sesuai permintaanmu
            $table->boolean('is_archived')->default(0); // 0 untuk dashboard utama
            $table->boolean('check_esurat')->default(false);
            $table->boolean('check_srikandi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
