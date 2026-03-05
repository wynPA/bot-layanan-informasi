<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLI MADE | Sistem Administrasi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; overflow-x: hidden; }
        /* Sidebar Styling */
        #sidebar { background: #1a1c23; min-height: 100vh; min-width: 250px; color: #fff; transition: all 0.3s; }
        .nav-link { color: #9da5b1; padding: 12px 20px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { color: #fff; background: #2d3139; border-left: 4px solid #3b82f6; }
        .nav-link.disabled { color: #fff; opacity: 0.4; cursor: not-allowed; }
        /* Card Styling */
        .stat-card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .table-card { border: none; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .bg-gradient-blue { background: linear-gradient(45deg, #1e3a8a, #3b82f6); }
        
        /* Kunci Lebar Kolom */
        .col-pengirim { width: 15%; }
        .col-waktu { width: 12%; }
        .col-utama { width: 22%; }
        .col-lampiran { width: 20%; }
        .col-status { width: 10%; }
        .col-proses { width: 21%; }

        /* Merapatkan Nama File dengan Icon */
        .file-wrapper {
            display: flex;
            align-items: center;
            gap: 8px; /* Jarak rapat antara teks dan icon */
            width: max-content; /* Membungkus isi agar icon menempel */
        }

        /* Mengunci Posisi Horizontal Checkbox */
        .check-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem; /* Mengecilkan font sesuai permintaan */
            width: 80px; /* Mengunci lebar area checkbox agar sejajar vertikal */
        }

        /* Limit karakter tetap dipertahankan */
        .file-name-limit {
            max-width: 150px; /* Sedikit diperkecil agar lebih compact */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Penumpukan Lampiran Vertikal */
        .attachment-stack {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* Hover Effect pada Link File */
        .file-link { color: #2d3139; text-decoration: none; }
        .file-link:hover { color: #3b82f6; }

        /* FAB Refresh - Sovereign Edition */
        .fab-refresh {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #2563eb); /* Biru solid mengkilap */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            border: none;
            transition: all 0.3s ease;
            z-index: 9999;
            cursor: pointer;
        }

        .fab-refresh:hover {
            transform: rotate(180deg) scale(1.1); /* Efek putar saat hover */
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        }

        .fab-refresh i, .fab-refresh svg {
            width: 28px;
            height: 28px;
        }

        /* Menghilangkan border biru saat input search di-klik */
        .form-control:focus {
            box-shadow: none;
            background-color: #f1f3f5 !important;
        }

        .cursor-pointer { cursor: pointer; }

        /* Animasi Spinner Bot tetap dipertahankan */
        .spinner-grow {
            animation: pulse-green 2s infinite;
        }

        .nav-link {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff !important;
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
            border-left: 3px solid #3b82f6;
            font-weight: 600;
        }

        /* Memastikan Sidebar tetap fixed atau scrollable jika menu banyak */
        #sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Font Inter atau Roboto sangat disarankan untuk kesan IT yang bersih */
        body { font-family: 'Inter', sans-serif; }

        /* Kontras elegan untuk label kategori */
        .sidebar-label {
            color: #64748b !important; /* Silver-grey yang kontras namun tidak mencolok */
            font-weight: 700;
            font-size: 0.65rem;
            letter-spacing: 1.5px;
        }

        /* Nav Link dengan icon monokrom */
        .nav-link {
            color: #94a3b8 !important; /* Abu-abu kebiruan yang tenang */
            font-size: 0.9rem;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .nav-link svg {
            width: 18px;
            height: 18px;
            stroke-width: 2; /* Garis ikon yang konsisten */
            transition: stroke 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active svg {
            stroke: #3b82f6; /* Hanya icon yang diberi aksen biru saat aktif */
        }

    </style>
</head>
<body>

<div class="d-flex">
    <div id="sidebar" class="d-none d-md-block shadow-lg border-end border-secondary border-opacity-10" style="width: 280px; background: #1a1c23; min-height: 100vh;">
        <div class="p-4 border-bottom border-secondary border-opacity-25">
            <!-- <div class="d-flex align-items-center gap-3"> -->
                <h5 class="text-white fw-bold mb-0" style="letter-spacing: 1px;">BLI MADE</h5>
            <!-- </div> -->
        </div>

        <div class="mt-auto p-4">
            <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                <small class="text-muted d-block mb-3 fw-bold" style="font-size: 0.65rem;">PERFORMA HARI INI</small>
                <div class="d-flex align-items-center justify-content-center position-relative mb-2">
                    <div class="donut-chart" style="width: 80px; height: 80px; border-radius: 50%; background: conic-gradient(#3b82f6 70%, #2d3139 0); position: relative;">
                        <div class="position-absolute top-50 start-50 translate-middle bg-navy rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #1a1c23;">
                            <span class="text-white fw-bold" style="font-size: 0.8rem;">70%</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <small class="text-white-50" style="font-size: 0.6rem;">Selesai: 14 / Total: 20</small>
                </div>
            </div>
        </div>

        <nav class="nav flex-column px-3 gap-1">
            <small class="sidebar-label px-3 mb-2 mt-2">MENU UTAMA</small>
            
            <a class="nav-link active rounded-3 d-flex align-items-center gap-3" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a class="nav-link rounded-3 d-flex align-items-center gap-3 {{ request()->is('surat-keluar*') ? 'active' : '' }}" 
            href="{{ route('surat-keluar.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                </svg>
                <span>Surat Keluar</span>
            </a>

            <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5M5 19v-4a2 2 0 00-2-2h14a2 2 0 002 2v2a2 2 0 00-2 2H5" />
                </svg>
                <span>Arsip Digital</span>
            </a>

            <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Konfigurasi Bot</span>
            </a>

            <small class="sidebar-label px-3 mt-4 mb-2">LAPORAN</small>
            
            <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                <span>Statistik Bulanan</span>
            </a>
        </nav>

    </div>

    <div class="flex-grow-1">
        <nav class="navbar navbar-expand navbar-light bg-white py-2 px-4 mb-4 shadow-sm border-bottom">
            <div class="d-flex align-items-center gap-3 flex-grow-1">
                <button class="btn btn-link text-dark p-0 border-0" id="sidebarToggle" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="position-relative w-50" style="height: 38px;">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="tableSearch" class="form-control border-0 bg-light rounded-3 h-100 ps-5" 
                        placeholder="Cari dokumen atau nomor pengirim..." onkeyup="filterTable()" 
                        style="font-size: 0.85rem; color: #475569;">
                </div>

                <div class="position-relative ms-2 opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
            </div>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill small">
                    <span class="spinner-grow spinner-grow-sm" style="width: 7px; height: 7px;"></span> Bot Active
                </span>

                <div class="vr opacity-25" style="height: 25px;"></div>

                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border: 1px dashed #ccc;">
                    <span style="font-size: 0.5rem; text-align: center;" class="text-muted fw-bold">LOGO<br>INSTANSI</span>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card stat-card bg-gradient-blue text-white p-4">
                        <small class="opacity-75 d-block">Tugas Masuk Hari Ini
                        <span class="badge bg-white text-primary x-small fw-bold mb-2" style="font-size: 0.65rem;">
                            {{ now()->translatedFormat('d F Y') }}
                        </span></small>
                        <h2 class="fw-bold mb-0">{{ $totalHarian }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card bg-white p-4 border-start border-primary border-5">
                        <small class="text-muted">Status: Pending Verification</small>
                        <h2 class="fw-bold mb-0" id="pending-count">
                            {{ $surat->where('status', '!=', 'Dibaca')->count() }}
                        </h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card bg-white p-4 border-start border-info border-5">
                        <small class="text-muted">Sistem Health</small>
                        <h2 class="fw-bold mb-0 text-info">
                            {{ $surat->count() > 10 ? 'Heavy Load' : 'Optimal' }}
                        </h2>
                    </div>
                </div>
            </div>
                
                <button onclick="window.location.reload()" class="fab-refresh" title="Refresh Data">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </button>

                @foreach($surat->groupBy('kategori') as $kategori => $items)
                <div class="card mb-5 border-0 shadow-sm" id="category-block-{{ Str::slug($kategori) }}">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">Kategori: {{ $kategori }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="table-layout: fixed;">
                            <thead class="bg-light">
                                <tr class="small text-muted text-uppercase">
                                    <th class="ps-4 col-pengirim">PENGIRIM</th>
                                    <th class="col-waktu">WAKTU</th>
                                    <th class="col-utama">FILE UTAMA</th>
                                    <th class="col-lampiran">LAMPIRAN</th>
                                    <th class="col-status">STATUS</th>
                                    <th class="pe-4 col-proses text-center">CHECKLIST PROSES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr id="row-{{ $item->id }}" class="surat-row">
                                    <td class="ps-4 fw-bold text-dark">{{ $item->nomor_hp_pengirim }}</td>
                                    <td class="small text-muted">{{ $item->created_at->format('H:i') }} <small>(Hari ini)</small></td>
                                    
                                    <td>
                                        <div class="file-wrapper">
                                            <span class="file-name-limit" title="{{ $item->nama_file_utama }}">
                                                📄 {{ $item->nama_file_utama }}
                                            </span>
                                            <a href="{{ asset('storage/'.$item->path_file) }}" target="_blank" onclick="updateStatus('{{ $item->id }}')" class="text-primary d-flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="attachment-stack">
                                            @forelse($item->lampirans as $l)
                                                <div class="d-flex align-items-center justify-content-between border rounded px-2 py-1 bg-light">
                                                    <span class="file-name-limit small" style="max-width: 120px;" title="{{ $l->nama_file_lampiran }}">{{ $l->nama_file_lampiran }}</span>
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

                                    <td>
                                        <span id="status-badge-{{ $item->id }}" 
                                            class="badge rounded-pill px-3 py-2 fw-bold {{ $item->status == 'Dibaca' ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning' }}"
                                            style="font-size: 0.75rem; min-width: 80px;">
                                            {{ $item->status }}
                                        </span>
                                    </td>

                                    <td class="pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="check-item">
                                                <input type="checkbox" class="process-check" 
                                                    {{ $item->check_esurat ? 'checked' : '' }} 
                                                    onchange="saveChecklist('{{ $item->id }}', 'esurat', this)">
                                                <span>E-SURAT</span>
                                            </div>
                                            @if(strtolower($kategori) == 'undangan')
                                            <div class="check-item">
                                                <input type="checkbox" class="process-check" 
                                                    {{ $item->check_srikandi ? 'checked' : '' }} 
                                                    onchange="saveChecklist('{{ $item->id }}', 'srikandi', this)">
                                                <span>SRIKANDI</span>
                                            </div>
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
                // 1. Trigger Status DIBACA saat Download diklik
                function updateStatus(id) {
                    const badge = document.getElementById(`status-badge-${id}`);
                    
                    if (badge.innerText.trim() !== 'Dibaca') {
                        // Hapus class warna kuning sepenuhnya termasuk border-nya
                        badge.classList.remove('bg-warning-subtle', 'text-warning', 'border-warning');
                        
                        // Tambahkan class hijau subtle LENGKAP dengan border
                        badge.classList.add('bg-success-subtle', 'text-success', 'border', 'border-success');
                        badge.innerText = 'Dibaca';

                        // Update angka statistik (Tetap)
                        const pendingElement = document.getElementById('pending-count');
                        let currentCount = parseInt(pendingElement.innerText);
                        if (currentCount > 0) {
                            pendingElement.innerText = currentCount - 1;
                        }
                        
                        fetch(`/update-status/${id}`, { 
                            method: 'POST', 
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
                        });
                    }
                }

                // 2. Fungsi Penyimpanan dengan "Satpam Penjaga" (PENTING!)
                function saveChecklist(id, type, element) {
                    const badge = document.getElementById(`status-badge-${id}`);
                    
                    // CEK STATUS DULU: Jika masih Pending, batalkan semua.
                    if (badge.innerText.trim().toLowerCase() === 'pending') {
                        alert("Surat ini masih berstatus pending, mohon baca isi dokumen sebelum mengisi checklist");
                        element.checked = false; // Batalkan centang di layar
                        return; // BERHENTI DI SINI: Data tidak akan dikirim ke server/database
                    }

                    // Jika lolos (Status sudah Dibaca), baru kirim ke database
                    fetch(`/update-checklist/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            type: type,
                            value: element.checked ? 1 : 0
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Setelah berhasil simpan, baru cek apakah sudah lengkap untuk di-archive
                        checkCompletion(id);
                    });
                }

                // 3. Logika Auto-Archive (Hanya fokus pada pindah data)
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
                            card.remove();
                        }
                    });
                }

                // A. Fungsi Toggle Sidebar (Hamburger)
                document.getElementById('sidebarToggle').addEventListener('click', function() {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar.classList.contains('d-md-block')) {
                        sidebar.classList.remove('d-md-block');
                        sidebar.classList.add('d-none');
                    } else {
                        sidebar.classList.add('d-md-block');
                        sidebar.classList.remove('d-none');
                    }
                });

                // B. Fungsi Real-Time Search (Filter Tabel)
                function filterTable() {
                    let input = document.getElementById("tableSearch");
                    let filter = input.value.toLowerCase();
                    let rows = document.querySelectorAll(".surat-row");

                    rows.forEach(row => {
                        // Cari di kolom Pengirim dan Nama File
                        let text = row.innerText.toLowerCase();
                        if (text.includes(filter)) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });

                    // Sembunyikan kategori jika semua isinya terfilter
                    document.querySelectorAll('[id^="category-block-"]').forEach(block => {
                        let visibleRows = block.querySelectorAll('.surat-row[style=""]');
                        block.style.display = visibleRows.length > 0 || filter === "" ? "" : "none";
                    });
                }

            </script>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>