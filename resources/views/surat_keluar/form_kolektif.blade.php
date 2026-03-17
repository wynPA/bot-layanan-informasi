<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Detail Surat - BLI MADE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f0f2f5; 
            font-family: 'Inter', sans-serif;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .form-container { max-width: 640px; margin: auto; }
        .form-header {
            border-top: 10px solid #0d6efd;
            border-radius: 8px;
            background: white;
            padding: 24px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .form-card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .form-label { font-weight: 600; color: #202124; font-size: 14px; }
        .form-control { border-bottom: 1px solid #ddd !important; border-top: none; border-left: none; border-right: none; border-radius: 0; padding-left: 0; }
        .form-control:focus { box-shadow: none; border-bottom: 2px solid #0d6efd !important; }
        .number-badge { background: #e8f0fe; color: #1967d2; font-weight: bold; padding: 4px 12px; border-radius: 4px; font-size: 13px; }
    </style>
</head>
<body>

<div class="form-container px-3">
    <div class="form-header">
        <h1 class="h3 fw-bold">Pencatatan Surat Keluar</h1>
        <p class="text-muted mb-0">Silakan lengkapi data perihal dan tujuan untuk nomor yang telah diterbitkan oleh Bot BLI MADE.</p>
        <hr class="my-3">
        <div class="d-flex align-items-center gap-2">
             <span class="small text-secondary">Token Sesi: <strong>{{ $token }}</strong></span>
        </div>
    </div>

    <form action="{{ url('/update-kolektif/' . $token) }}" method="POST">
        @csrf
        @foreach($daftarSurat as $s)
        <div class="form-card">
            <div class="mb-4">
                <span class="number-badge">Nomor: {{ $s->nomor_lengkap }}</span>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Tujuan Surat *</label>
                <input type="text" name="surat[{{ $s->id }}][tujuan]" class="form-control" placeholder="Jawaban Anda" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Perihal / Isi Ringkas Surat *</label>
                <textarea name="surat[{{ $s->id }}][perihal]" class="form-control" rows="1" placeholder="Jawaban Anda" required></textarea>
            </div>

            <div class="mb-2">
                <label class="form-label">Tanggal Surat *</label>
                <input type="date" name="surat[{{ $s->id }}][tgl_surat]" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between align-items-center mt-4">
            <button type="submit" class="btn btn-primary px-4 fw-bold">Kirim Data</button>
            <span class="text-muted small">Jangan bagikan token ini.</span>
        </div>
    </form>
</div>

</body>
</html>