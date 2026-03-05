<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika nama tabelmu surat_keluars)
    protected $table = 'surat_keluar';

    // Daftar kolom yang boleh diisi secara massal
    protected $fillable = [
        'nomor_urut',
        'nomor_lengkap',
        'tahun',
        'judul',
        'perihal',
        'tgl_surat',
        'tujuan',
        'whatsapp_number',
        'session_token',
        'status_isi',
        'tgl_retensi',
        'file_surat'
    ];

    protected $casts = [
    'tgl_surat' => 'date',
    'tgl_retensi' => 'date',
    ];
}
