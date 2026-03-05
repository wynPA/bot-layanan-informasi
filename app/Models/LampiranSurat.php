<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranSurat extends Model
{
    protected $table = 'lampiran_surat';
    protected $fillable = [
    'surat_masuk_id', 
    'nama_file_lampiran', 
    'path_file'
    ];

    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
}
