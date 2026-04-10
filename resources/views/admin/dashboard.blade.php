@extends('admin.layout-admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-shell">
    <div class="section">
        <div class="hero">
            <div>
                <p class="eyebrow">Control Panel • Real-time overview</p>
                <h1>Dashboard Admin Kampung Tematik</h1>
                <p class="lede">Pantau pesanan, pembayaran, dan kinerja secara cepat.</p>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Laporan Hari Ini</h3>
            <span class="muted">Admin/</span>
        </div>
        <div class="cards">
            <div class="card">
                <div>
                    <span class="label">Total Seluruh Pesanan Hari Ini</span>
                    <div class="value">Rp. {{ number_format($todayStats['total']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $todayStats['total']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-blue">📊</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Pesanan Berhasil Hari Ini</span>
                    <div class="value">Rp. {{ number_format($todayStats['success']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $todayStats['success']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-green">✅</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Pesanan Pending Hari Ini</span>
                    <div class="value">Rp. {{ number_format($todayStats['pending']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $todayStats['pending']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-cyan">⏳</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Pesanan Batal Hari Ini</span>
                    <div class="value">Rp. {{ number_format($todayStats['cancelled']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $todayStats['cancelled']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-red">🗑️</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Deposit Hari Ini</span>
                    <div class="value">Rp. {{ number_format($todayStats['deposit']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $todayStats['deposit']['count'] }}x pembayaran</small>
                </div>
                <div class="icon-box icon-blue">💰</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Laporan Keseluruhan</h3>
            <span class="muted">Admin/</span>
        </div>
        <div class="cards">
            <div class="card">
                <div>
                    <span class="label">Total Seluruh Pesanan</span>
                    <div class="value">Rp. {{ number_format($overallStats['total']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $overallStats['total']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-blue">📊</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Pesanan Berhasil Keseluruhan</span>
                    <div class="value">Rp. {{ number_format($overallStats['success']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $overallStats['success']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-green">✅</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Pesanan Pending Keseluruhan</span>
                    <div class="value">Rp. {{ number_format($overallStats['pending']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $overallStats['pending']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-cyan">⏳</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Pesanan Batal Keseluruhan</span>
                    <div class="value">Rp. {{ number_format($overallStats['cancelled']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $overallStats['cancelled']['count'] }}x pemesanan</small>
                </div>
                <div class="icon-box icon-red">🗑️</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Total Deposit Keseluruhan</span>
                    <div class="value">Rp. {{ number_format($overallStats['deposit']['amount'], 0, ',', '.') }}</div>
                    <small>Dengan total {{ $overallStats['deposit']['count'] }}x pembayaran</small>
                </div>
                <div class="icon-box icon-yellow">💰</div>
            </div>
            <div class="card">
                <div>
                    <span class="label">Keuntungan Bersih Keseluruhan</span>
                    <div class="value">Rp. {{ number_format($overallStats['profit']['amount'], 0, ',', '.') }}</div>
                    <small>Estimasi {{ $overallStats['profit']['count'] }} pembayaran</small>
                </div>
                <div class="icon-box icon-blue">📈</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Grafik Pesanan 7 Hari Terakhir</h3>
        </div>
        <div class="panel">
            <canvas id="orders7Chart" class="chart-placeholder"></canvas>
        </div>
    </div>

    <div class="footer">
        <span>2025 @ Kampung Tematik</span>
        <span>About Us • Help • Contact Us</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.orders7d = @json($orders7d);
</script>
@endpush
