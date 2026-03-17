<x-app-layout>
<div class="d-flex">
    <div class="container-fluid px-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-uppercase">Log Penomoran Surat Keluar</h6>
                    <button class="btn btn-sm btn-outline-primary rounded-3">Refresh Data</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">No. Urut</th>
                            <th>Nomor Lengkap</th>
                            <th>Detail</th>
                            <th >Status</th>
                            <th class="text-center">Pengirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $item->nomor_urut }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nomor_lengkap }}</span><br>
                                <small class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td >
                                <a href="{{ url('/isi-detail/'.$item->session_token) }}" class="btn btn-sm btn-light border">
                                    🔗 Link
                                </a>
                            </td>
                            
                            <td>
                                <span class="badge rounded-pill px-3 {{ $item->status_isi == 'pending' ? 'bg-warning-subtle text-warning border border-warning' : 'bg-success-subtle text-success border border-success' }}">
                                    {{ strtoupper($item->status_isi) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $item->whatsapp_number }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">Belum ada data surat keluar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
</x-app-layout>