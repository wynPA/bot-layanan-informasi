<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        /* Sidebar Styling */
        #sidebar { 
            background: #1a1c23; 
            min-height: 100vh; 
            min-width: 250px; 
            color: #fff; 
            transition: all 0.3s; 
            position: sticky; 
            top: 0; 
            display: flex; 
            flex-direction: column; 
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
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            transition: stroke 0.3s ease;
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

        .nav-link.active svg {
            stroke: #3b82f6;
        }
    </style>
</head>
<body>
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
</body>