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
        \App\Models\SuratKeluar::where('status_isi', 'completed')
            ->whereDate('created_at', '<', \Carbon\Carbon::today())
            ->where('is_archived', 0)
            ->update(['is_archived' => 1]);

        $today = \Carbon\Carbon::today();

        // 1. ANTREAN PENDING: Ambil semua yang 'pending' dari SEBELUM hari ini
        // Ini adalah "hutang" yang harus segera diingatkan ke operator
        $antreanPending = \App\Models\SuratKeluar::where('status_isi', 'pending')
                            ->where('created_at', '<', $today)
                            ->where('is_archived', 0)
                            ->orderBy('created_at', 'asc')
                            ->get();

        // 2. LOG HARI INI: Semua surat yang dibuat hari ini (baik pending maupun completed)
        // Ini menjaga urutan nomor surat tetap konsisten (001, 002, 003...)
        $logHariIni = \App\Models\SuratKeluar::whereDate('created_at', $today)
                            ->where('is_archived', 0)
                            ->orderBy('nomor_urut', 'asc')
                            ->get();

        return view('surat_keluar.index', compact('antreanPending', 'logHariIni'));
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
        // 1. Ambil data berdasarkan token
        $daftarSurat = SuratKeluar::where('session_token', $token)->get();

        // 2. Cek apakah token ada di database
        if ($daftarSurat->isEmpty()) {
            abort(404, 'Token tidak ditemukan.');
        }

        // 3. PROTEKSI WAKTU: Cek apakah sudah expired
        // (Gunakan data pertama sebagai perwakilan karena satu token satu waktu expired)
        if (Carbon::now()->greaterThan($daftarSurat->first()->expired_at)) {
            return view('surat_keluar.error', [
                'message' => 'Maaf, batas waktu pengisian link ini telah berakhir.'
            ]);
        }

        // 4. PROTEKSI STATUS (ANTI-BACK): Cek jika sudah pernah diisi
        if ($daftarSurat->contains('status_isi', 'completed')) {
            return view('surat_keluar.success_isi', [
                'message' => 'Detail surat untuk sesi ini sudah lengkap dan tersimpan.'
            ]);
        }

        // 5. Jika lolos semua sensor di atas, baru tampilkan form
        return view('surat_keluar.form_kolektif', compact('daftarSurat', 'token'));
    }

    // 4. Proses Simpan Bulk (Update Banyak Data Sekaligus)
    public function updateKolektif(Request $request, $token)
    {
        // Mengambil semua data input dari array 'surat' di form
        $dataSurat = $request->input('surat');
        $today = \Carbon\Carbon::today();

        if (!$dataSurat) {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }

        DB::transaction(function () use ($dataSurat, $token, $today) {
            foreach ($dataSurat as $id => $input) {
                $surat = \App\Models\SuratKeluar::where('id', $id)
                                    ->where('session_token', $token)
                                    ->firstOrFail();
                
                // Tentukan apakah ini data "Hutang" (dibuat sebelum hari ini)
                $isHutang = $surat->created_at < $today;

                $surat->update([
                    'tujuan'      => $input['tujuan'],
                    'perihal'     => $input['perihal'],
                    'tgl_surat'   => $input['tgl_surat'],
                    'status_isi'  => 'completed',
                    // JIKA hutang, langsung arsipkan (1). JIKA hari ini, biarkan di dashboard (0).
                    'is_archived' => $isHutang ? 1 : 0 
                ]);
            }
        });

        return redirect()->route('surat-keluar.success-page', ['token' => $token]);
    }

    public function showSuccess($token)
    {
        // Cek apakah token valid untuk keamanan tambahan
        $surat = \App\Models\SuratKeluar::where('session_token', $token)->first();
        
        if (!$surat) { abort(404); }

        return view('surat_keluar.success_isi', [
            'message' => 'Seluruh data surat berhasil disimpan! Silakan kembali ke WhatsApp.'
        ]);
    }

    public function arsipkanSelesai()
    {
        // Pindahkan semua yang 'completed' ke arsip (is_archived = 1)
        SuratKeluar::where('status_isi', 'completed')
                    ->where('is_archived', 0)
                    ->update(['is_archived' => 1]);

        return redirect()->back()->with('success', 'Semua surat selesai telah dipindahkan ke arsip.');
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