<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">    
    
    <style>
        :root {
            /* Kontrol lebar search bar di mobile di sini (0-100%) */
            --search-mobile-width: 85%; 
        }

        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; overflow-x: hidden; }

        /* --- SIDEBAR --- */
        #sidebar { 
            background: #1a1c23; 
            height: 100vh;
            min-width: 250px;
            max-width: 250px; 
            color: #fff; 
            display: flex; 
            flex-direction: column; 
            z-index: 2000; 
            position: sticky;
            top: 0;
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

        /* --- RESPONSIVE MOBILE --- */
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
                left: 10px !important;
                bottom: 80px !important;
            }

            /* Penyesuaian lebar Search Bar di Mobile */
            .search-container {
                width: var(--search-mobile-width) !important;
                max-width: 35% !important;
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

            <div class="flex-grow-1 overflow-y-auto">
                <div class="p-4">
                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                        <small class="text-muted d-block mb-3 fw-bold" style="font-size: 0.65rem;">STATUS NOMOR</small>
                    </div>
                </div>

                <nav class="nav flex-column px-3 gap-1">
                    <small class="sidebar-label px-3 mb-2 mt-2">MENU UTAMA</small>      
                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="/dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a class="nav-link active rounded-3 d-flex align-items-center gap-3 {{ request()->is('surat-keluar*') ? 'active' : '' }}" href="{{ route('surat-keluar.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        <span>Surat Keluar</span>
                    </a>

                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5M5 19v-4a2 2 0 00-2-2h14a2 2 0 002 2v2a2 2 0 00-2 2H5" />
                        </svg>
                        <span>Arsip Digital</span>
                    </a>

                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Konfigurasi Bot</span>
                    </a>

                    <small class="sidebar-label px-3 mt-4 mb-2">LAPORAN</small>
                    
                    <a class="nav-link rounded-3 d-flex align-items-center gap-3" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        <span>Statistik Bulanan</span>
                    </a>
                </nav>
            </div>

            <div class="mt-auto p-3 border-top border-secondary border-opacity-10">
                <div class="d-flex align-items-center gap-3 p-2 rounded-3 cursor-pointer user-field-hover position-relative" 
                    onclick="toggleUserMenu()" id="userMenuTrigger">
                    
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
        <div class="flex-grow-1 bg-light">
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
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
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
    </script>
</body>
</html>