<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi PIN - Kampung Tematik</title>
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
                <h1>Verifikasi PIN</h1>
                <p class="lede">Masukkan PIN admin untuk masuk dashboard.</p>
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

            <form method="POST" action="{{ route('admin.pin.verify') }}" class="form">
                @csrf
                <label>
                    <span>PIN</span>
                    <input type="password" name="pin" pattern="\d{6,10}" title="PIN 6-10 digit angka" required autofocus placeholder="Masukkan PIN">
                </label>

                <button type="submit" class="btn-primary">Verifikasi PIN</button>
            </form>

            <div class="meta">
                <div class="pill">Langkah 3/3</div>
                <p>Gunakan PIN yang sudah dibuat untuk melanjutkan.</p>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/admin-auth.js') }}"></script>
</body>
</html>
