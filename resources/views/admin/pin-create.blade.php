<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat PIN Admin - Kampung Tematik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-auth.css') }}">
</head>
<body>
    <div class="bg-aurora" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <canvas id="particleCanvas"></canvas>
    </div>

    <main class="auth-shell">
        <div class="card glass">
            <div class="header">
                <p class="eyebrow">Area Admin</p>
                <h1>Buat PIN Admin</h1>
                <p class="lede">Akun Anda belum memiliki PIN. Buat PIN 6-10 digit untuk melanjutkan.</p>
            </div>

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert error">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            @if (str_contains($error, 'confirmation'))
                                <li>Pin anda tidak sama coba lagi!</li>
                            @else
                                <li>{{ $error }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.pin.store') }}" class="form">
                @csrf
                <label>
                    <span>PIN Baru</span>
                    <input type="password" name="pin" pattern="\d{6,10}" title="PIN 6-10 digit angka" required autofocus placeholder="Masukkan PIN">
                </label>
                <label>
                    <span>Konfirmasi PIN</span>
                    <input type="password" name="pin_confirmation" pattern="\d{6,10}" title="PIN 6-10 digit angka" required placeholder="Ulangi PIN">
                </label>
                <button type="submit" class="btn-primary">Simpan PIN</button>
            </form>

            <div class="meta">
                <div class="pill">Langkah 2/2</div>
                <p>Setelah PIN dibuat, Anda akan diminta verifikasi PIN untuk masuk.</p>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/admin-auth.js') }}"></script>
</body>
</html>
