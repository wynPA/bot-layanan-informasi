<x-app-layout>
    <style>
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
    </style>

    <div class="container-fluid px-4 ">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 border-top border-warning border-5">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning-subtle text-warning p-3 rounded-3 me-3">
                                <i class="bi bi-box-seam fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Transit & Penataan</h5>
                                <small class="text-muted">Perlu Lokasi Fisik</small>
                            </div>
                        </div>
                        <div class="p-3 rounded-3" style="background-color: whitesmoke; margin-bottom: 10px;">
                            <h1 class="display-5 fw-bold mb-3 text-center">{{ $countTransit }}</h1>
                        </div>
                        
                        <p class="text-muted mb-4 flex-grow-1" style="text-align: justify;">Dokumen yang baru dipindahkan. Segera kemas ke dalam rak dan box untuk mengamankan data fisik.</p>
                        
                        <a href="{{ route('arsip.transit') }}" class="btn btn-warning fw-bold py-3 rounded-3">
                            MULAI PENATAAN <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 border-top border-primary border-5">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle text-primary p-3 rounded-3 me-3">
                                <i class="bi bi-archive fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Gudang Utama</h5>
                                <small class="text-muted">Arsip Terlokasi</small>
                            </div>
                        </div>
                        <div class="p-3 rounded-3" style="background-color: whitesmoke; margin-bottom: 10px;">
                            <h1 class="display-5 fw-bold mb-3 text-center">{{ $countPermanen }}</h1>
                        </div>
                        
                        <p class="text-muted mb-4 flex-grow-1" style="text-align: justify;">Seluruh arsip yang sudah tersimpan rapi di rak. Gunakan untuk pencarian lokasi atau pemindahan box.</p>
                        
                        <a href="{{ route('arsip.permanen') }}" class="btn btn-primary fw-bold py-3 rounded-3">
                            LIHAT GUDANG <i class="bi bi-search ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 border-top border-danger border-5">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger-subtle text-danger p-3 rounded-3 me-3">
                                <i class="bi bi-trash3 fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Jadwal Retensi</h5>
                                <small class="text-muted">Siap Dimusnahkan</small>
                            </div>
                        </div>
                        <div class="p-3 rounded-3" style="background-color: whitesmoke; margin-bottom: 10px;">
                            <h1 class="display-5 fw-bold text-center">{{ $countMusnah }}</h1>
                        </div>
                        <p class="text-muted mb-4 flex-grow-1" style="text-align: justify;">Dokumen yang telah melewati masa aktif. Tinjau kembali daftar ini sebelum melakukan pemusnahan fisik.</p>
                        
                        <a href="{{ route('arsip.retensi') }}" class="btn btn-outline-danger fw-bold py-3 rounded-3">
                            TINJAU RETENSI <i class="bi bi-exclamation-triangle ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>