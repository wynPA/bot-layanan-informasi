<x-app-layout>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Gates
        </a>
        <h4 class="fw-bold mb-0 text-warning"><i class="bi bi-box-seam me-2"></i> Antrean Transit Fisik</h4>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal Masuk</th>
                            <th>Judul/Perihal Arsip</th>
                            <th>Asal Sumber</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-bold">{{ $item->judul_arsip }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-3">
                                    {{ str_replace('App\\Models\\', '', $item->archivable_type) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm rounded-3 fw-bold" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalInput-{{ $item->id }}">
                                    <i class="bi bi-pencil-square me-1"></i> Input Lokasi
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalInput-{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <form action="{{ route('arsip.update-location', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold">Penempatan Lokasi Fisik</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Kategori Arsip</label>
                                                <select name="kategori" class="form-select rounded-3" required>
                                                    <option value="" disabled selected>Pilih Kategori...</option>
                                                    <option value="Keuangan">Keuangan (Retensi 10th)</option>
                                                    <option value="Kepegawaian">Kepegawaian (Retensi 5th)</option>
                                                    <option value="Umum">Umum (Retensi 5th)</option>
                                                    <option value="Lainnya">Lainnya (Retensi 3th)</option>
                                                </select>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Nomor Rak</label>
                                                    <input type="text" name="no_rak" class="form-control rounded-3" placeholder="Contoh: R-01" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Nomor Box</label>
                                                    <input type="text" name="no_box" class="form-control rounded-3" placeholder="Contoh: B-99" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Nomor Sampul (Opsional)</label>
                                                    <input type="text" name="no_sampul" class="form-control rounded-3" placeholder="Contoh: S-001">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="submit" class="btn btn-warning w-100 rounded-3 fw-bold py-2">SIMPAN KE GUDANG</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted italic">
                                <i class="bi bi-check-circle fs-2 d-block mb-2"></i>
                                Semua dokumen transit telah terlokasi.
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