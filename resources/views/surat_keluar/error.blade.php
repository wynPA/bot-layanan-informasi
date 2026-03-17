<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Kedaluwarsa - BLI MADE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f0f0; font-family: 'Inter', sans-serif; }
        .error-card { max-width: 500px; margin: 100px auto; background: white; border-radius: 8px; border-top: 10px solid #dc3545; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="error-card p-5">
            <h2 class="text-danger fw-bold">Waktu Habis!</h2>
            <p class="mt-3">{{ $message }}</p>
            <p class="small text-muted">Silakan minta nomor baru melalui Bot WhatsApp BLI MADE.</p>
        </div>
    </div>
</body>
</html>