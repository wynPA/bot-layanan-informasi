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
                    <thead class="align-middle bg-light">
                        <tr>
                            <th class="ps-4 d-none d-md-table-cell" style="width: 15%;">Masuk pada</th>
                            <th class="text-center align-middle" style="width: 18%;">Judul</th>
                            <th class="d-none d-md-table-cell" style="width: 8%;">Sumber</th>
                            <th class="d-none d-md-table-cell text-center" style="width: 14%;">Fisik Dokumen</th>
                            <th class="d-none d-md-table-cell text-center" style="width: 15%">Kategori</th>
                            <th class="d-none d-md-table-cell text-center" style="width: 15%">Lokasi Penyimpanan</th>
                            <th class="pe-4 text-center align-middle" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <form action="{{ route('arsip.update-location', $item->id) }}" method="POST">
                            @csrf
                                <td class="d-none d-md-table-cell  ps-4 text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>                                                         
                                    {{ str_replace('.pdf', '', $item->judul_arsip) }}
                                </td> 
                                <td class="d-none d-md-table-cell">
                                    <span class="badge {{ $item->archivable_type == 'App\Models\SuratMasuk' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} border border-opacity-10">
                                        {{ $item->archivable_type == 'App\Models\SuratMasuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                                    </span>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <select name="fisik_dokumen" class="form-select form-select-sm border-warning-subtle shadow-sm" required>
                                        <option value="" disabled selected>-- Kondisi --</option>
                                        @foreach($doct as $f)
                                            <option value="{{ $f->nama }}">{{ $f->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>                            
                                <td class="d-none d-md-table-cell">
                                    <select name="kategori" class="form-select form-select-sm border-warning-subtle shadow-sm" required>
                                        <option value="" disabled selected>-- Kategori --</option>
                                        @foreach($category as $cat)
                                            <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="d-none d-md-table-cell"> 
                                    <div class="d-flex flex-column gap-1">
                                        <select name="no_rak" class="form-select form-select-sm border-warning-subtle" required>
                                            <option value="" disabled selected>Pilih Rak...</option>
                                            @foreach($listRak as $rak)
                                                <option value="{{ $rak->nama }}">{{ $rak->nama }}</option>
                                            @endforeach
                                        </select>

                                        <select name="no_box" class="form-select form-select-sm border-warning-subtle" required>
                                            <option value="" disabled selected>Pilih Box...</option>
                                            @foreach($listBox as $box)
                                                <option value="{{ $box->nama }}">{{ $box->nama }}</option>
                                            @endforeach
                                        </select>

                                        <input type="text" name="no_sampul" class="form-control form-control-sm" placeholder="Nomor Sampul">
                                    </div>
                                </td>
                                <!-- <td class="text-center pe-4">
                                    <button class="btn btn-warning btn-sm rounded-1 fw-bold"> 
                                        <i class="bi bi-floppy"></i>
                                    </button>
                                </td> -->
                                <td class="text-center">
                                    <button type="submit" class="btn btn-warning rounded-1 fw-bold d-none d-md-inline-block">
                                        <i class="bi bi-floppy"></i>
                                    </button>

                                    <button type="button" class="btn btn-warning shadow-sm d-md-none" 
                                            data-bs-toggle="modal" data-bs-target="#modalMobile-{{ $item->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </form> 
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