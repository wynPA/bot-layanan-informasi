<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil Terkirim - BLI MADE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .success-card { max-width: 500px; margin: 100px auto; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 10px solid #198754; }
    </style>
</head>
<body>
    <div class="container px-3">
        <div class="success-card p-5 text-center">
            <div class="mb-4 text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <h2 class="fw-bold mb-3">Berhasil Terkirim!</h2>
            <p class="text-muted mb-4">{{ $message }}</p>
            <hr class="my-4 opacity-25">
            <p class="small text-secondary mb-0">Terima kasih telah menggunakan sistem <strong>BLI MADE</strong></p>
            <p class="small text-muted mt-1">DISKOMINFOS Kota Denpasar</p>
        </div>
    </div>
    
<script>
        // 1. Tambahkan state baru ke riwayat browser
        history.pushState(null, null, location.href);

        // 2. Setiap kali user mencoba kembali (back), paksa tetap di halaman ini
        window.onpopstate = function () {
            history.pushState(null, null, location.href);
        };

        // 3. Opsional: Tambahkan penutup tab otomatis (khusus untuk beberapa browser mobile/WA)
        // Kadang tombol ini membantu user agar tidak bingung
    </script>
</body>
</html>