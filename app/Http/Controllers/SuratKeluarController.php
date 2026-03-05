<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratKeluar; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SuratKeluarController extends Controller
{
    // Menampilkan daftar surat keluar di Dashboard
    public function index()
    {
        $data = SuratKeluar::orderBy('created_at', 'desc')->get();
        return view('surat_keluar.index', compact('data'));
    }

    // Fungsi Utama: Generator Nomor untuk Bot WA
    public function generateFromBot(Request $request)
    {
        // Simulasi input dari Webhook WA
        $jumlah = $request->input('jumlah', 1); // Default 1 nomor
        $whatsapp = $request->input('sender'); 
        $tahun = date('Y');
        $token = Str::random(16);

        return DB::transaction(function () use ($jumlah, $whatsapp, $tahun, $token) {
            // 1. Ambil nomor urut terakhir di tahun ini
            $lastNumber = SuratKeluar::where('tahun', $tahun)->max('nomor_urut') ?? 0;
            
            $results = [];

            for ($i = 1; $i <= $jumlah; $i++) {
                $newUrut = $lastNumber + $i;
                // Format: 001/DISKOMINFOS/2026 (dengan padding nol didepan)
                $formatted = str_pad($newUrut, 3, '0', STR_PAD_LEFT) . "/DISKOMINFOS/" . $tahun;

                $surat = SuratKeluar::create([
                    'nomor_urut' => $newUrut,
                    'nomor_lengkap' => $formatted,
                    'tahun' => $tahun,
                    'whatsapp_number' => $whatsapp,
                    'session_token' => $token,
                    'status_isi' => 'pending'
                ]);

                $results[] = $formatted;
            }

            // 2. Berikan respon balik ke Bot WA
            return response()->json([
                'status' => 'success',
                'message' => 'Nomor berhasil diterbitkan',
                'numbers' => $results,
                'url_kolektif' => url('/isi-detail/' . $token)
            ]);
        });
    }
}
