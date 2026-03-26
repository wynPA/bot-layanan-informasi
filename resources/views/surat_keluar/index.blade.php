<x-app-layout>
<style>
    /* Mengunci layout tabel agar tidak bergerak secara dinamis */
    .table-log-surat {
        table-layout: fixed !important;
        width: 100% !important;
    }

    /* Penentuan Lebar per Kolom (Sovereign Precision) */
    .col-urut     { width: 10%; } /* Kolom No. Urut */
    .col-nomor    { width: 22%; } /* Kolom Nomor Lengkap & Tanggal */
    .col-perihal  { width: 27%; } /* Kolom Perihal (Area paling luas) */
    .col-detail   { width: 10%; } /* Kolom Link Detail */
    .col-status   { width: 12%; } /* Kolom Status */
    .col-pengirim { width: 18%; } /* Kolom WA Pengirim */

    /* Memastikan teks perihal bisa turun ke bawah (wrap) */
    .table-log-surat td.perihal-cell {
        white-space: normal !important;
        word-wrap: break-word;
        vertical-align: top; /* Agar teks mulai dari atas saat baris meninggi */
    }

    /* Kolom lainnya tetap satu baris (nowrap) agar rapi */
    .table-log-surat td:not(.perihal-cell) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="d-flex">
    <div class="container-fluid px-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-uppercase">Log Penomoran Surat Keluar</h6>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 col-urut">No. Urut</th>
                            <th class="col-nomor">Nomor Lengkap</th>
                            <th class="text-center col-perihal">Perihal</th>
                            <th class="text-center col-detail">Form</th>
                            <th class="text-center col-status">Status</th>
                            <th class="col-pengirim">Pengirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr class="surat-row">
                            <td class="ps-4 fw-bold">#{{ $item->nomor_urut }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nomor_lengkap }}</span><br>
                                <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="text-center" style="white-space: normal !important;">
                                @if($item->perihal)
                                    <div class="text-dark fw-medium small text-start" style="text-align: justify; min-width: 150px; line-height: 1.4;">
                                        {{ $item->perihal }}
                                    </div>
                                @else
                                    <span class="text-muted small italic">Belum diisi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/isi-detail/'.$item->session_token) }}" 
                                class="btn btn-sm btn-light border" 
                                target="_blank" 
                                rel="noopener noreferrer">
                                    <i class="bi bi-link-45deg"></i> Link
                                </a>
                            </td>
                            
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 {{ $item->status_isi == 'pending' ? 'bg-warning-subtle text-warning border border-warning' : 'bg-success-subtle text-success border border-success' }}">
                                    {{ strtoupper($item->status_isi) }}
                                </span>
                            </td>
                            <td>{{ $item->whatsapp_number }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">Belum ada data surat keluar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
</div>
<script>
    function filterTable() {
        let input = document.getElementById("tableSearch"); // ID dari navbar utama
        if(!input) return;
        
        let filter = input.value.toLowerCase();
        let rows = document.querySelectorAll(".surat-row");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });

        document.querySelectorAll('[id^="category-block-"]').forEach(block => {
            let visibleRows = block.querySelectorAll('.surat-row:not([style*="display: none"])');
            block.style.display = visibleRows.length > 0 || filter === "" ? "" : "none";
        });
    }
</script>
</x-app-layout>