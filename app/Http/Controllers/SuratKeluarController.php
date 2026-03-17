<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratKeluarController extends Controller
{
    // 1. Dashboard: Lihat semua surat
    public function index()
    {
        $data = SuratKeluar::orderBy('created_at', 'desc')->get();
        return view('surat_keluar.index', compact('data'));
    }

    // 2. Fungsi Utama: Generator & Reservasi Nomor (Dipicu Bot WA)
    public function generateFromBot(Request $request)
    {
        $jumlah = $request->input('jumlah', 1); // Antara 1-10
        $whatsapp = $request->input('sender'); 
        $tahun = date('Y');
        $token = Str::random(16);
        
        // Menghitung Expired (1 Hari Kerja)
        $expiredAt = $this->calculateExpiry(1);

        return DB::transaction(function () use ($jumlah, $whatsapp, $tahun, $token, $expiredAt) {
            $lastNumber = SuratKeluar::where('tahun', $tahun)->max('nomor_urut') ?? 0;
            $results = [];

            for ($i = 1; $i <= $jumlah; $i++) {
                $newUrut = $lastNumber + $i;
                $formatted = str_pad($newUrut, 3, '0', STR_PAD_LEFT) . "/DISKOMINFOS/" . $tahun;

                SuratKeluar::create([
                    'session_token' => $token,
                    'nomor_urut' => $newUrut,
                    'nomor_lengkap' => $formatted,
                    'tahun' => $tahun,
                    'whatsapp_number' => $whatsapp,
                    'status_isi' => 'pending',
                    'expired_at' => $expiredAt
                ]);

                $results[] = $formatted;
            }

            return response()->json([
                'status' => 'success',
                'numbers' => $results,
                'token' => $token,
                'expired_until' => $expiredAt->format('d-m-Y H:i'),
                'url_form' => url('/isi-detail/' . $token)
            ]);
        });
    }

    // 3. Menampilkan Form Bulk (Satu Link untuk Banyak Nomor)
    public function formKolektif($token)
    {
        // Ambil semua nomor yang memiliki token yang sama
        $daftarSurat = SuratKeluar::where('session_token', $token)->get();

        if ($daftarSurat->isEmpty()) {
            abort(404, 'Token tidak valid.');
        }

        // Cek apakah sudah expired
        if (Carbon::now()->greaterThan($daftarSurat->first()->expired_at)) {
            return view('surat_keluar.error', ['message' => 'Maaf, batas waktu pengisian link ini telah berakhir.']);
        }

        // Cek jika sudah pernah diisi
        if ($daftarSurat->first()->status_isi == 'completed') {
            return view('surat_keluar.success_isi', ['message' => 'Detail surat sudah pernah dilengkapi.']);
        }

        return view('surat_keluar.form_kolektif', compact('daftarSurat', 'token'));
    }

    // 4. Proses Simpan Bulk (Update Banyak Data Sekaligus)
    public function updateKolektif(Request $request, $token)
    {
        // Mengambil semua data input dari array 'surat' di form
        $dataSurat = $request->input('surat'); 

        if (!$dataSurat) {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }

        DB::transaction(function () use ($dataSurat, $token) {
            foreach ($dataSurat as $id => $input) {
                // Cari surat berdasarkan ID dan Token untuk keamanan   
                $surat = SuratKeluar::where('id', $id)
                                    ->where('session_token', $token)
                                    ->firstOrFail();
                
                // Update hanya kolom yang tersedia di database & form baru
                $surat->update([
                    'tujuan'   => $input['tujuan'],
                    'perihal'  => $input['perihal'], // Menggunakan key 'perihal' dari form
                    'tgl_surat' => $input['tgl_surat'],
                    'status_isi' => 'completed'
                ]);
            }
        });

        return view('surat_keluar.success_isi', [
            'message' => 'Seluruh data surat berhasil disimpan! Silakan kembali ke WhatsApp.'
        ]);
    }

    // 5. Helper: Algoritma Hari Kerja (Excl. Sabtu & Minggu)
    private function calculateExpiry($days = 1) {
        $date = now();
        $addedDays = 0;
        
        while ($addedDays < $days) {
            $date->addDay();
            if (!$date->isWeekend()) {
                $addedDays++;
            }
        }
        return $date;
    }
}