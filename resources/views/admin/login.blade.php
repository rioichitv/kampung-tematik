<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login • Kampung Tematik</title>
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
                <h1>Login Admin</h1>
                <p class="lede">Masuk untuk mengelola dashboard Kampung Tematik.</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="form">
                @csrf
                <label>
                    <span>Email Admin</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required placeholder="••••••••">
                </label>
                @error('email')
                    <div class="alert">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-primary">Masuk Dashboard</button>
            </form>

            <div class="meta">
                <div class="pill">/admin</div>
                <p>Jika belum punya akun admin, tambahkan via database.</p>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/admin-auth.js') }}"></script>
</body>
</html>
