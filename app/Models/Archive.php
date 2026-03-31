<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $guarded = [];

    /**
     * Relasi ke model asal (SuratMasuk atau SuratKeluar)
     */
    public function archivable()
    {
        return $this->morphTo();
    }
}
