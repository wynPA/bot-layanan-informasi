<x-app-layout>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Gates
        </a>
        <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-archive me-2"></i> Gudang Utama (Inventaris Aktif)</h4>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInventory" class="form-control rounded-3" placeholder="Cari Judul, Rak, atau Nomor Box...">
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tableInventory">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Lokasi Fisik</th>
                            <th>Judul Arsip</th>
                            <th>Kategori</th>
                            <th>Masa Aktif Hingga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr class="inventory-row">
                            <td class="ps-4">
                                <span class="badge bg-dark px-2 py-1">Rak: {{ $item->no_rak }}</span>
                                <span class="badge bg-secondary px-2 py-1">Box: {{ $item->no_box }}</span>
                            </td>
                            <td class="fw-bold">{{ $item->judul_arsip }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>
                                @if($item->tgl_pemusnahan)
                                    <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_pemusnahan)->format('d M Y') }}</small>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $item->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Script pencarian lokal untuk efisiensi tablet
    document.getElementById('searchInventory').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.inventory-row');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
        });
    });
</script>
</x-app-layout>