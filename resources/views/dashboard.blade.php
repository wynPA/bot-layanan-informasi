<x-app-layout>
<style>
    /* Mengunci layout tabel agar tidak bergerak */
        .table-fixed-layout {
            table-layout: fixed !important;
            width: 100% !important;
        }

        /* Penentuan Lebar per Kolom (Sovereign Precision) */
        .col-pengirim { width: 16%; }
        .col-waktu    { width: 12%; }
        .col-file     { width: 20%; }
        .col-lampiran { width: 20%; }
        .col-status   { width: 13%; }
        .col-proses   { width: 21%; } /* Ruang ini akan tetap 16% meski isinya hanya 1 checkbox */

        /* Memastikan teks panjang tidak merusak kotak */
        .table-fixed-layout td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
</style>
    <div class="container-fluid px-0">
        @php
            $hariIndo = [
                'Monday'    => 'SEN', 'Tuesday'   => 'SEL', 'Wednesday' => 'RAB',
                'Thursday'  => 'KAM', 'Friday'    => 'JUM', 'Saturday'  => 'SAB', 'Sunday'    => 'MIN'
            ];
            $dayName = $hariIndo[now()->format('l')];
        @endphp

        <div class="stats-bar-sovereign mb-4">
            <div class="date-box">
                <span class="date-number text-muted">{{ now()->format('d-m-Y') }}</span>
                <span class="day-name">{{ $dayName }}</span>
            </div>
            
            <div class="stat-item">
                <span class="stat-value">{{ $totalMenunggu }}</span>
                <span class="stat-label">Menunggu</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">{{ $totalTerproses }}</span>
                <span class="stat-label">Diproses</span>
            </div>

            <div class="stats-divider d-none d-md-block"></div>

            <div class="d-flex align-items-center gap-2">
                <div class="waiting-icon-circle d-none d-md-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <div class="stat-item text-start">
                    <div class="d-flex align-items-baseline gap-1">
                        <small class="stat-label text-uppercase opacity-75" style="padding-right: 5px;">Total</small>
                        <span class="stat-value" id="pending-count" >{{ $totalSuratHarian }}</span>
                    </div>
                    <span class="stat-label">Surat Harian</span>
                </div>
            </div>
        </div>

        @foreach($surat->groupBy('kategori') as $kategori => $items)
        <div class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden" id="category-block-{{ Str::slug($kategori) }}">
            <div class="card-header bg-white border-0 py-3 ps-4">
                <h6 class="fw-bold mb-0 text-primary" style="letter-spacing: 1px;">
                    <i class="bi bi-folder2-open me-2"></i>KATEGORI: {{ strtoupper($kategori) }}
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-fixed-layout">
                    <colgroup>
                        <col class="col-pengirim">
                        <col class="col-waktu">
                        <col class="col-file">
                        <col class="col-lampiran">
                        <col class="col-status">
                        <col class="col-proses">
                    </colgroup>
                    <thead class="bg-light">
                        <tr class="small text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
                            <th class="ps-4">PENGIRIM</th>
                            <th class="text-center">DITERIMA PADA</th>
                            <th class="text-center">FILE UTAMA</th>
                            <th class="text-center">LAMPIRAN</th>
                            <th class="text-center">STATUS</th>
                            <th class="pe-4 text-center">CHECKLIST PROSES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr id="row-{{ $item->id }}" class="surat-row border-bottom">
                            <td class="ps-4 fw-bold text-dark">{{ $item->nomor_hp_pengirim }}</td>
                            <td class="small text-center">{{ $item->created_at->format('d M, H:i') }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <span class="text-truncate" style="max-width: 180px;" title="{{ $item->nama_file_utama }}">📄 {{ $item->nama_file_utama }}</span>
                                    <a href="{{ asset('storage/'.$item->path_file) }}" target="_blank" onclick="updateStatus('{{ $item->id }}')" class="btn btn-sm btn-light p-1 rounded text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="attachment-stack">
                                    @forelse($item->lampirans as $l)
                                        <div class="d-flex align-items-center justify-content-between border rounded px-2 py-1 bg-light">
                                            <span class="text-truncate small" style="max-width: 140px;" title="{{ $l->nama_file_lampiran }}">{{ $l->nama_file_lampiran }}</span>
                                            <a href="{{ asset('storage/'.$l->path_file) }}" target="_blank" class="text-primary ms-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @empty
                                        <span class="text-muted small italic">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="text-center">
                                <span id="status-badge-{{ $item->id }}" class="badge rounded-pill px-3 py-2 {{ $item->status == 'Dibaca' ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning' }}" style="font-size: 0.7rem;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-3">
                                    <label class="small d-flex align-items-center gap-1 cursor-pointer">
                                        <input type="checkbox" class="process-check" {{ $item->check_esurat ? 'checked' : '' }} onchange="saveChecklist('{{ $item->id }}', 'esurat', this)"> E-SURAT
                                    </label>
                                    @if(strtolower($kategori) == 'undangan')
                                    <label class="small d-flex align-items-center gap-1 cursor-pointer">
                                        <input type="checkbox" class="process-check" {{ $item->check_srikandi ? 'checked' : '' }} onchange="saveChecklist('{{ $item->id }}', 'srikandi', this)"> SRIKANDI
                                    </label>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>

<script>
    // Refresh halaman setiap 2 menit (120000 ms)
    setTimeout(function()
    {
       location.reload();
    }, 120000);
    
    // 1. Update Status ke 'Dibaca' & Update Statistik Bar
    function updateStatus(id) {
        const badge = document.getElementById(`status-badge-${id}`);
        if (badge && badge.innerText.trim() !== 'Dibaca') {
            badge.classList.remove('bg-warning-subtle', 'text-warning', 'border-warning');
            badge.classList.add('bg-success-subtle', 'text-success', 'border', 'border-success');
            badge.innerText = 'Dibaca';

            // Update angka di Stats Bar minimalis
            const pendingElement = document.getElementById('pending-count');
            if (pendingElement) {
                let currentCount = parseInt(pendingElement.innerText);
                if (currentCount > 0) pendingElement.innerText = currentCount - 1;
            }
            
            fetch(`/update-status/${id}`, { 
                method: 'POST', 
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
            });
        }
    }

    // 2. Satpam Checklist: Cegah input sebelum dibaca
    function saveChecklist(id, type, element) {
        const badge = document.getElementById(`status-badge-${id}`);
        if (badge.innerText.trim().toLowerCase() === 'pending') {
            alert("Surat ini masih berstatus pending. Mohon baca dokumen terlebih dahulu!");
            element.checked = false;
            return;
        }

        fetch(`/update-checklist/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type, value: element.checked ? 1 : 0 })
        })
        .then(response => response.json())
        .then(data => { checkCompletion(id); });
    }

    // 3. Animasi Auto-Archive
    function checkCompletion(id) {
        const row = document.getElementById(`row-${id}`);
        const checkboxes = row.querySelectorAll('.process-check');
        const allChecked = Array.from(checkboxes).every(c => c.checked);

        if (allChecked) {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                row.remove();
                fetch(`/archive-surat/${id}`, { 
                    method: 'POST', 
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
                });
                checkEmptyCategory();
            }, 500);
        }
    }

    function checkEmptyCategory() {
        document.querySelectorAll('[id^="category-block-"]').forEach(card => {
            if (card.querySelectorAll('.surat-row').length === 0) {
                card.style.transition = 'opacity 0.4s ease';
                card.style.opacity = '0';
                setTimeout(() => card.remove(), 400);
            }
        });
    }

    // 4. Pencarian Real-Time (Terintegrasi dengan Navbar)
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