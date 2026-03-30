<x-app-layout>
<style>
    /* Mengunci layout tabel agar tidak bergerak secara dinamis */
    .table-log-surat {
        table-layout: fixed !important;
        width: 100% !important;
    }

    /* Penentuan Lebar per Kolom (Sovereign Precision) */
    .col-urut     { width: 10%; }
    .col-nomor    { width: 22%; }
    .col-perihal  { width: 27%; }
    .col-detail   { width: 10%; }
    .col-status   { width: 12%; }
    .col-pengirim { width: 18%; }

    /* Memastikan teks perihal bisa turun ke bawah (wrap) */
    .table-log-surat td.perihal-cell {
        white-space: normal !important;
        word-wrap: break-word;
        vertical-align: top;
    }

    /* Kolom lainnya tetap satu baris (nowrap) agar rapi */
    .table-log-surat td:not(.perihal-cell) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Baris yang sudah selesai akan sedikit meredup */
    .row-completed {
        background-color: #f8f9fa !important;
        transition: all 0.3s ease;
        opacity: 0.8;
    }

    .row-completed td {
        color: #6c757d !important; 
    }

    .row-completed:hover {
        opacity: 1;
        background-color: #f1f3f5 !important;
    }

    .row-completed .text-dark {
        color: #6c757d !important;
    }
</style>

<div class="d-flex">
    <div class="container-fluid px-4">

        @if($antreanPending->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 border-start ">
            <div class="card-header bg-warning-subtle border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-uppercase text-warning-emphasis">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Antrean Tertunda
                    </h6>
                    <span class="badge bg-warning text-dark rounded-pill">{{ $antreanPending->count() }} Surat</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-log-surat">
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
                        @foreach($antreanPending as $item)
                        <tr class="surat-row bg-warning-subtle bg-opacity-10">
                            <td class="ps-4 fw-bold">#{{ $item->nomor_urut }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nomor_lengkap }}</span><br>
                                <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="perihal-cell">
                                @if($item->perihal)
                                    <div class="text-dark fw-medium small" style="{{'text-align: justify;'}} min-width: 150px; line-height: 1.4;">
                                        {{ $item->perihal }}
                                    </div>
                                @else
                                    <span class="text-muted small italic">Menunggu input dari petugas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/isi-detail/'.$item->session_token) }}" class="btn btn-sm btn-light border" target="_blank">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-uppercase text-primary">Log Penomoran Hari Ini</h6>
                    <form action="{{ url('/surat-keluar/arsipkan-selesai') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success shadow-sm" title="Bersihkan ke Arsip">
                            <i class="bi bi-archive-fill"></i> 
                            <span class="d-none d-md-inline ms-1">Bersihkan ke Arsip</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-log-surat">
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
                        @forelse($logHariIni as $item)
                        <tr class="surat-row {{ $item->status_isi == 'completed' ? 'row-completed' : '' }}">
                            <td class="ps-4 fw-bold">#{{ $item->nomor_urut }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nomor_lengkap }}</span><br>
                                <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="perihal-cell">
                                @if($item->perihal)
                                    <div class="text-dark fw-medium small" 
                                         style="{{'text-align: justify;'}} min-width: 150px; line-height: 1.4;">
                                        {{ $item->perihal }}
                                    </div>
                                @else
                                    <span class="text-muted small italic">Menunggu input dari petugas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/isi-detail/'.$item->session_token) }}" class="btn btn-sm btn-light border" target="_blank">
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
                            <td colspan="6" class="text-center py-5 text-muted italic">Belum ada aktivitas penomoran hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>  
</div>

<script>
    // Refresh halaman setiap 2 menit (120000 ms)
    setTimeout(function()
    {
       location.reload();
    }, 120000);

    function filterTable() {
        let input = document.getElementById("tableSearch");
        if(!input) return;
        
        let filter = input.value.toLowerCase();
        let rows = document.querySelectorAll(".surat-row");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    }
</script>
</x-app-layout>