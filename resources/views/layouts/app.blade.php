<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@400;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
    
    <style>
        :root {
            /* Kontrol lebar search bar di mobile di sini (0-100%) */
            --search-mobile-width: 85%; 
        }

        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; overflow-x: hidden; }

        /* --- SIDEBAR --- */
        #sidebar { 
            background: #1a1c23; 
            min-height: 100vh; 
            height: auto;
            min-width: 250px;
            max-width: 250px; 
            color: #fff; 
            display: flex; 
            flex-direction: column; 
            z-index: 2000; 
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .sidebar-label {
            color: #64748b !important;
            font-weight: 700;
            font-size: 0.65rem;
            letter-spacing: 1.5px;
        }

        .nav-link {
            color: #94a3b8 !important;
            font-size: 0.9rem;
            padding: 10px 15px;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
            border-left: 3px solid #3b82f6;
            font-weight: 600;
        }
        /* Bagian Footer Sidebar (Profil User) */
        .sidebar-user-footer {
            margin-top: auto; /* Dorong ke paling bawah */
            background: #1a1c23; /* Pastikan warnanya sama dengan sidebar */
            position: sticky;
            bottom: 0;
            z-index: 10;
            /* Tambahkan sedikit shadow agar terlihat terpisah saat menu di-scroll */
            border-top: 1px solid rgba(255, 255, 255, 0.05); 
        }

        .flex-grow-1.bg-light {
            margin-left: 250px; /* Beri ruang untuk sidebar di Desktop */
            width: calc(100% - 250px);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        #sidebar.d-none ~ .flex-grow-1.bg-light {
            margin-left: 0;
            width: 100%;
        }

        /* Area Menu agar bisa di-scroll mandiri di dalam sidebar */
        .sidebar-menu-content {
            flex-grow: 1;
            overflow-y: auto; /* Menu bisa di-scroll jika kepanjangan */
            scrollbar-width: none; /* Sembunyikan scrollbar untuk tampilan bersih */
        }
        /* .sidebar-menu-content::-webkit-scrollbar { display: none; } */

        /* --- USER MENU & FLOATING --- */
        .user-floating-menu {
            display: none;
            position: fixed;
            left: 260px;
            bottom: 10px;
            width: 170px;
            background: #1a1c23;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            z-index: 2100;
            box-shadow: 15px 5px 30px rgba(0,0,0,0.4);
        }

        .user-floating-menu.active { display: block; animation: slideInLeft 0.2s ease-out; }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .nav-link-custom:hover { background: rgba(255,255,255,0.05); color: #fff; }

        .user-field-hover:hover { background: rgba(255, 255, 255, 0.08) !important; cursor: pointer; }

        .indicator-chevron { transition: transform 0.3s ease; color: #64748b; }

        /* --- NAVBAR --- */
        .navbar { z-index: 1000; }
        .search-container { transition: width 0.3s ease; }

        /* Container Utama Card */
        .stats-bar-sovereign {
            background: #ffffff;
            border-radius: 16px;
            padding: 12px 24px;
            display: inline-flex; /* Agar tidak memenuhi lebar dashboard */
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
            margin-bottom: 25px;
        }

        /* Kalender Area (Kiri) */
        .date-box {
            text-align: center;
            padding-right: 15px;
            
        }
        .date-number {
            font-size: 0.75rem;
            color: #64748b;
            display: block;
           
        }
        .day-name {
            font-size: 2rem;
            font-weight: 700;
            color: #3b82f6; /* Biru sesuai desainmu */
            text-transform: uppercase;
            line-height: 1;
            font-family: 'Inria Serif', serif;
        }

        /* Divider Vertikal */
        .stats-divider {
            width: 1px;
            height: 40px;
            background-color: #000000;
        }

        /* Angka & Label */
        .stat-item { text-align: center; min-width: 60px; }
        .stat-value { font-size: 1.6rem; font-weight: 700; color: #1e293b; display: block; line-height: 1; padding-top: 8px; }
        .stat-label { font-size: 0.7rem; color: #64748b; font-weight: 600; }

        /* Ikon Jam Menunggu */
        .waiting-icon-circle {
            background-color: #fffbeb;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f59e0b;
            margin-right: 10px;
        }

        /* --- FAB SYSTEM (Clean & Integrated) --- */
        /* 1. Kontainer Utama: Menumpuk FAB secara vertikal di pojok */
        .fab-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1100;
            display: flex;
            flex-direction: column; /* Tumpuk ke bawah */
            gap: 15px; /* Jarak antar tombol (reposisi) */
            align-items: center; /* Sejajar tengah */
        }

        /* 2. Class Universal: Desain Lingkaran, Ukuran, dan Shadow yang SAMA */
        .fab-universal {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            /* CSS bawaan agar SVG di dalamnya pas */
            padding: 0; 
        }

        /* 3. Gaya Khusus: FAB Refresh (Biru Mengkilap + Efek Putar) */
        .fab-refresh {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }

        .fab-refresh:hover {
            transform: rotate(180deg) scale(1.1); /* Efek putar sakti */
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        }

        /* 4. Gaya Khusus: FAB Scroll (Abu-abu Netral + Efek Naik) */
        .fab-scroll {
            display: none; /* Default tersembunyi, diatur JS */
            background: #f1f5f9; /* Abu-abu netral */
            color: #64748b; /* Panah abu-abu tua */
            border: 2px solid #e2e8f0;
        }

        .fab-scroll:hover {
            transform: translateY(-5px) scale(1.1); /* Efek naik sakti */
            background: #e2e8f0;
            color: #334155;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* 5. Ukuran Icon Universal di dalam FAB */
        .fab-universal svg {
            width: 28px;
            height: 28px;
        }

        

        /* 1. Kustomisasi Scrollbar Sidebar */
        .sidebar-content-sovereign::-webkit-scrollbar {
            width: 5px; /* Buat sangat tipis agar tidak memotong area */
        }

        .sidebar-content-sovereign::-webkit-scrollbar-track {
            background: transparent; /* Latar belakang track transparan agar tidak memotong sidebar */
        }

        .sidebar-content-sovereign::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1); /* Warna abu-abu sangat tipis */
            border-radius: 10px;
        }

        .sidebar-content-sovereign:hover::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3); /* Sedikit lebih terang saat di-hover */
        }

        /* Update: Targetkan class pembungkus menu di sidebar kamu */
        .flex-grow-1.overflow-y-auto::-webkit-scrollbar {
            width: 5px; 
        }

        .flex-grow-1.overflow-y-auto::-webkit-scrollbar-track {
            background: transparent; 
        }

        .flex-grow-1.overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 10px;
        }

        .flex-grow-1.overflow-y-auto:hover::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3); 
        }

/* ------------------------------------------------ */
/* --- --------- RESPONSIVE MOBILE ------------ --- */
/* ------------------------------------------------ */
        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed !important;
                left: -250px !important;
                transition: left 0.3s ease-in-out;
            }

            #sidebar.show-mobile { left: 0 !important; }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0;
                width: 100vw; height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1500;
                backdrop-filter: blur(2px);
            }

            .sidebar-overlay.active { display: block; }

            .user-floating-menu {
                left: 17px !important;
                bottom: 80px !important;
            }


            /* 1. Paksa area utama mengambil lebar penuh agar tabel tidak terdorong */
            .flex-grow-1.bg-light {
                margin-left: 0 !important;
                width: 100% !important;
                overflow-x: hidden; 
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* 2. Search Container: Sesuai eksperimenmu (35%) */
            .search-container {
                width: var(--search-mobile-width) !important;
                max-width: 73% !important;
                flex: none !important; /* Mencegah flexbox memaksa lebar lain */
            }

            /* 3. Tabel Responsive: Agar tabel bisa di-scroll di dalam kotaknya saja */
            main {
                padding: 10px !important;
            }
            
            /* Gunakan selector langsung ke tabel agar tidak perlu wrapper div baru */
            table {
                display: block;
                width: 100%;
                overflow-x: auto;
                white-space: nowrap; /* Mencegah teks nomor surat pecah jadi 2 baris */
            }

            /* Memastikan Nama Instansi Benar-benar Hilang di Mobile */
            .instansi-text {
                display: none !important;
            }

            /* Logo Instansi tetap muncul di kanan */
            .navbar .ms-auto {
                display: flex !important;
                align-items: center;
            }

            .navbar { padding: 0.5rem 0.75rem !important; }

            .date-box { display: none; }
            .stats-divider {
                display: block !important; 
                width: 1px; 
                height: 30px; 
                background-color: #000000; 
                align-self: center;
            }
            .stats-bar-sovereign { width: 100%; display: flex; justify-content: space-around; }
            
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="d-flex">
        <div id="userFloatingMenu" class="user-floating-menu p-2"> 
            <a class="nav-link-custom rounded-3" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Account</span>
            </a>
            <hr class="my-2 border-secondary border-opacity-25">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link-custom text-danger border-0 w-100 text-start bg-transparent rounded-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
        
        <div id="sidebar">
            <div class="px-4 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/logo-bli-made.png') }}" alt="Logo" class="img-fluid" style="max-height: 65px;">
            </div>

            <div class="flex-grow-1 overflow-y-auto sidebar-content-sovereign">
                <div class="p-4">
                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                        <small class="text-muted d-block mb-3 fw-bold" style="font-size: 0.65rem;">STATUS NOMOR</small>
                    </div>
                </div>

                <nav class="nav flex-column px-3 gap-1">
                    <small class="sidebar-label px-3 mb-2 mt-2">ADMINISTRASI SURAT</small>      
                    <a class="nav-link rounded-3 d-flex align-items-center gap-3 {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-envelope-paper"></i>
                        <span>Surat Masuk</span>
                    </a>

                    <a class="nav-link rounded-3 d-flex align-items-center gap-3 {{ request()->is('surat-keluar*') ? 'active' : '' }}" href="{{ route('surat-keluar.index') }}">                        
                        <i class="bi bi-paperclip"></i>
                        <span>Surat Keluar</span>
                    </a>

                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <i class="bi bi-archive"></i>
                        <span>Arsip Digital</span>
                    </a>

                    <small class="sidebar-label px-3 mt-4 mb-2">OPSI PENGEMBANG</small>
                    
                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <i class="bi bi-gear"></i>
                        <span>Konfigurasi</span>
                    </a>
                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <i class="bi bi-clock-history"></i>
                        <span>Log Aktifitas</span>
                    </a>
                    
                    <small class="sidebar-label px-3 mt-4 mb-2">LAINNYA</small>

                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <i class="bi bi-question-circle"></i>
                        <span>Petunjuk</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-user-footer p-3">
                <div class="d-flex align-items-center gap-3 p-2 rounded-3 user-field-hover" onclick="toggleUserMenu()" id="userMenuTrigger">                
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                        <span class="text-white fw-bold">{{ substr(Auth::user()->name ?? 'W', 0, 1) }}</span>
                    </div>
                    
                    <div class="flex-grow-1 overflow-hidden text-start">
                        <p class="text-white mb-0 fw-semibold small text-truncate">{{ Auth::user()->name ?? 'Wayn' }}</p>
                        <small style="color: #64748b; font-size: 0.7rem;" class="d-block">Admin</small>
                    </div>

                    <div class="indicator-chevron">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- navbar -->
        <div id="contentArea" class="flex-grow-1 bg-light">
            <nav class="navbar navbar-expand navbar-light bg-white py-2 px-4 mb-4 shadow-sm border-bottom">
                <div class="d-flex align-items-center gap-2 gap-md-3 flex-grow-1">
                    <button class="btn btn-link text-dark p-0 border-0" id="sidebarToggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>

                    <div class="position-relative search-container" style="height: 38px; width: 40%; max-width: 500px;">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                        <input type="text" id="tableSearch" class="form-control border-0 bg-light rounded-3 h-100 ps-5" placeholder="Cari..." onkeyup="filterTable()" style="font-size: 0.85rem;">
                    </div>

                    <div class="position-relative ms-2 opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="text-end d-none d-lg-block instansi-text">
                        <p class="mb-0 fw-bold text-dark" style="font-size: 0.75rem; line-height: 1.2;">
                            DINAS KOMUNIKASI, INFORMATIKA<br>DAN STATISTIK KOTA DENPASAR
                        </p>
                    </div>
                    
                    <div class="vr opacity-25 d-none d-lg-block" style="height: 30px;"></div>
                    
                    <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                        style="width: 40px; height: 40px; border: 1px dashed #ccc;">
                        <span style="font-size: 0.45rem;" class="text-muted fw-bold">LOGO<br>INSTANSI</span>
                    </div>
                </div>
            </nav>

            <main class="p-4">
                {{ $slot }}
            </main>

            <div class="fab-container">
                
                <button id="scrollToTopBtn" class="fab-universal fab-scroll shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                    </svg>
                </button>

                <button id="refreshFab" class="fab-universal fab-refresh" onclick="location.reload();">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const content = document.querySelector('.flex-grow-1.bg-light');
            
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('show-mobile');
                if (overlay) overlay.classList.toggle('active');
            } else {
                // Desktop toggle
                sidebar.classList.toggle('d-none');
            }
        }

        // Gunakan pengecekan keberadaan element agar tidak error di console
        const sidebarBtn = document.getElementById('sidebarToggle');
        if(sidebarBtn) {
            sidebarBtn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSidebar();
            });
        }

        const overlayBtn = document.getElementById('sidebarOverlay');
        if(overlayBtn) {
            overlayBtn.addEventListener('click', toggleSidebar);
        }
        
        function toggleUserMenu() {
            const menu = document.getElementById('userFloatingMenu');
            menu.classList.toggle('active');
        }

        window.onclick = function(event) {
            const menu = document.getElementById('userFloatingMenu');
            const trigger = document.getElementById('userMenuTrigger');
            if (!trigger.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('active');
            }
        }

        const scrollBtn = document.getElementById("scrollToTopBtn");

        // Munculkan tombol saat scroll turun 300px
        window.onscroll = function() {
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                scrollBtn.style.display = "flex";
            } else {
                scrollBtn.style.display = "none";
            }
        };

        // Logika Scroll ke Atas saat diklik
        scrollBtn.onclick = function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth" // Efek scroll halus ala High Science
            });
        };
    </script>
</body>
</html>