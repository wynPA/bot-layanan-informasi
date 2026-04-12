<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArsipController extends Controller
{
    /**
     * Tampilan Utama: Trinity Gates (3 Cards)
     */
    public function index()
    {
        $today = Carbon::today();

        // 1. Hitung Antrean Transit (Lokasi fisik masih kosong)
        $countTransit = Archive::whereNull('no_rak')
                                ->orWhereNull('no_box')
                                ->count();

        // 2. Hitung Gudang Utama (Sudah ada lokasi & belum masa musnah)
        $countPermanen = Archive::whereNotNull('no_rak')
                                ->whereNotNull('no_box')
                                ->where(function($q) use ($today) {
                                    $q->whereNull('tgl_pemusnahan')
                                      ->orWhere('tgl_pemusnahan', '>', $today);
                                })->count();

        // 3. Hitung Jadwal Musnah (Sudah lewat masa retensi)
        $countMusnah = Archive::whereNotNull('tgl_pemusnahan')
                                ->where('tgl_pemusnahan', '<=', $today)
                                ->count();

    return view('arsip.index', compact('countTransit', 'countPermanen', 'countMusnah'));
    }

    /**
     * Gerbang 1: Laman Transit (Untuk pengisian lokasi fisik)
     */
    public function transit()
    {
        $data = Archive::with('archivable') // Load data surat asalnya
                        ->whereNull('no_rak')
                        ->orWhereNull('no_box')
                        ->orderBy('created_at', 'desc')
                        ->get();

        $doct = [
            (object)['id' => 1, 'nama' => 'Asli'],
            (object)['id' => 2, 'nama' => 'Fotokopi'],
            (object)['id' => 3, 'nama' => 'Salinan'],
        ];

        $category = [
            (object)['id' => 1, 'nama' => 'Keuangan'],
            (object)['id' => 2, 'nama' => 'Kepegawaian'],
            (object)['id' => 3, 'nama' => 'Umum'],
            (object)['id' => 4, 'nama' => 'Lainnya'],
        ];
        
        $listRak = [
            (object)['id' => 1, 'nama' => 'I'],
            (object)['id' => 2, 'nama' => 'II'],
            (object)['id' => 3, 'nama' => 'III'],
        ];

        $listBox = [
            (object)['id' => 1, 'nama' => '1'],
            (object)['id' => 2, 'nama' => '2'],
            (object)['id' => 3, 'nama' => '3'],
        ];

        return view('arsip.transit', compact('data', 'doct', 'category', 'listRak', 'listBox'));
    }

    public function permanen()
    {
        $today = \Carbon\Carbon::today();
        $data = Archive::with('archivable')
                        ->whereNotNull('no_rak')
                        ->whereNotNull('no_box')
                        ->where(function($q) use ($today) {
                            $q->whereNull('tgl_pemusnahan')
                            ->orWhere('tgl_pemusnahan', '>', $today);
                        })
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return view('arsip.permanen', compact('data'));
    }

    /**
     * Simpan Lokasi Fisik (Update dari Laman Transit)
     */
    public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'no_rak'   => 'required',
            'no_box'   => 'required',
        ]);

        $archive = Archive::findOrFail($id);
        
        $updateData = [
            'kategori'   => $request->kategori,
            'no_rak'     => $request->no_rak,
            'no_box'     => $request->no_box,
            'no_sampul'  => $request->no_sampul,
        ];

        // LOGIKA AUTOMASI RETENSI BERDASARKAN KATEGORI:
        $kategori = $request->kategori;
        $now = Carbon::now();

        if ($kategori == 'Keuangan') {
            $updateData['tgl_pemusnahan'] = $now->addYears(10);
        } 
        else {
            $updateData['tgl_pemusnahan'] = $now->addYears(5);
        }

        $archive->update($updateData);

        return redirect()->back()->with('success', 'Lokasi fisik berhasil dicatat! Dokumen kini berada di Gudang Utama.');
    }

    public function retensi()
    {
        $today = \Carbon\Carbon::today();
        // Cari data yang masa aktifnya sudah habis
        $data = \App\Models\Archive::with('archivable')
                    ->whereNotNull('tgl_pemusnahan')
                    ->where('tgl_pemusnahan', '<=', $today)
                    ->orderBy('tgl_pemusnahan', 'asc')
                    ->get();

        return view('arsip.retensi', compact('data'));
    }

    public function destroy($id)
    {
        $archive = \App\Models\Archive::findOrFail($id);
        // Di sini kamu bisa tambahkan logika hapus file fisik di storage jika perlu
        $archive->delete();

        return redirect()->back()->with('success', 'Arsip telah berhasil dimusnahkan dari sistem.');
    }
}