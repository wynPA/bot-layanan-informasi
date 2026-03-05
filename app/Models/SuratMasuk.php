<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    protected $fillable = [
        'nomor_hp_pengirim', 
        'nama_file_utama', 
        'path_file', 
        'group_id_wa',  
        'status',
        'kategori',
        'is_archived',
        'check_esurat',
        'check_srikandi'
    ];

    public function lampirans()
    {
        return $this->hasMany(LampiranSurat::class);
    }
}
