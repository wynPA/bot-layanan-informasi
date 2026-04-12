<x-app-layout>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Gates
        </a>
        <h4 class="fw-bold mb-0 text-danger"><i class="bi bi-trash3-fill me-2"></i> Jadwal Retensi (Siap Musnah)</h4>
    </div>

    <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
        <div>
            <strong>Peringatan Keamanan:</strong> Daftar di bawah adalah arsip yang telah melewati masa retensi. Pastikan pemusnahan fisik telah dilakukan sebelum menghapus data dari sistem.
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-danger-subtle text-danger">
                        <tr>
                            <th class="ps-4">Lokasi Terakhir</th>
                            <th>Judul Arsip</th>
                            <th>Kategori</th>
                            <th>Kadaluwarsa Sejak</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-dark">R: {{ $item->no_rak }}</span>
                                <span class="badge bg-secondary">B: {{ $item->no_box }}</span>
                            </td>
                            <td class="fw-bold">{{ Str::replace('.pdf', '', $item->judul_arsip) }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td class="text-danger fw-bold">
                                {{ \Carbon\Carbon::parse($item->tgl_pemusnahan)->diffForHumans() }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('arsip.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin dokumen fisik sudah dimusnahkan? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-3">
                                        <i class="bi bi-fire me-1"></i> Musnahkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-shield-check fs-1 d-block mb-2 text-success"></i>
                                Tidak ada arsip yang memerlukan pemusnahan saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>