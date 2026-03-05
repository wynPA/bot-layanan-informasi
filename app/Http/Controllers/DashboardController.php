<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\LampiranSurat;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function updateStatus($id) {
        $surat = \App\Models\SuratMasuk::findOrFail($id);
        $surat->update(['status' => 'Dibaca']);
        return response()->json(['success' => true]);
    }

    public function updateChecklist(Request $request, $id) {
        $surat = SuratMasuk::findOrFail($id);
        $type = $request->type; // 'esurat' atau 'srikandi'
        
        if($type == 'esurat') {
            $surat->update(['check_esurat' => $request->value]);
        } else {
            $surat->update(['check_srikandi' => $request->value]);
        }

        return response()->json(['success' => true]);
    }

    public function archive($id) {
        $surat = \App\Models\SuratMasuk::findOrFail($id);
        $surat->update(['is_archived' => 1]);
        return response()->json(['success' => true]);
    }

    public function index() {
        // 1. Data aktif di tabel (yang belum di-arsip)
        $surat = \App\Models\SuratMasuk::where('is_archived', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        // 2. LOGIKA BARU: Total Dokumen Masuk KHUSUS HARI INI
        $totalHarian = \App\Models\SuratMasuk::whereDate('created_at', now()->toDateString())
                        ->count();
        
        return view('dashboard', compact('surat', 'totalHarian'));
    }

    public function storeFromBot(Request $request) {
        return DB::transaction(function () use ($request) {
            
            $kategoriInput = $request->input('kategori', 'Lainnya'); 

            $surat = SuratMasuk::create([
                'nomor_hp_pengirim' => $request->sender,
                'nama_file_utama'   => $request->pdf_name,
                'path_file'         => $request->pdf_path,
                'group_id_wa'       => $request->group_id,
                'kategori'          => $kategoriInput, 
                'status'            => 'Pending',      
            ]);

            // Jika ada lampiran (Gambar), simpan semuanya
            if ($request->has('attachments') && is_array($request->attachments)) {
                foreach ($request->attachments as $file) {
                    LampiranSurat::create([
                        'surat_masuk_id'     => $surat->id,
                        'nama_file_lampiran' => $file['name'],
                        'path_file'          => $file['path'],
                    ]);
                }
            }

            return response()->json(['message' => 'Data berhasil masuk sistem!'], 201);
        });
    }
}