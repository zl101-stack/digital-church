@extends('layouts.user')

@section('content')

<style>
    /* -----------------------------------------------------------
       1. CORE LAYOUT & RESET
    ----------------------------------------------------------- */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #020617;
        background: radial-gradient(circle at top right, #1e1b4b 0%, #020617 60%, #000000 100%);
        color: white;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        min-height: 100vh;
        overflow-x: hidden;
    }

    .topbar {
        width: 100%;
        height: 70px;
        padding: 0 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .brand {
        font-size: 20px;
        font-weight: 800;
        background: linear-gradient(to right, #38bdf8, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .profile-box {
        background: rgba(255, 255, 255, 0.05);
        padding: 8px 18px;
        border-radius: 12px;
        font-size: 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .wrapper {
        display: flex;
        width: 100%;
        min-height: calc(100vh - 70px);
    }

    /* -----------------------------------------------------------
       2. SIDEBAR STYLING
    ----------------------------------------------------------- */
    .sidebar {
        width: 260px;
        flex-shrink: 0;
        padding: 30px 15px;
        background: rgba(2, 6, 23, 0.4);
        border-right: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        flex-direction: column;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        margin-bottom: 6px;
        color: #94a3b8;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.3s;
        font-weight: 500;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.03);
        color: white;
        transform: translateX(4px);
    }

    .sidebar a.active {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        color: white;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.3);
    }

    .logout {
        margin-top: 20px;
        background: rgba(239, 68, 68, 0.05) !important;
        color: #f87171 !important;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    /* -----------------------------------------------------------
       3. CONTENT AREA & HERO
    ----------------------------------------------------------- */
    .content {
        flex: 1;
        padding: 30px;
        /* Sedikit dikurangi agar grid lebih luas */
        width: 100%;
    }

    .hero {
        background: linear-gradient(to bottom, rgba(2, 6, 23, 0.2), rgba(2, 6, 23, 0.9)),url('{{ asset('gereja.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 28px;
        margin-bottom: 40px;
        min-height: 300px;
        display: flex;
        align-items: flex-end;
        padding: 40px;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .hero-content {
        position: relative;
        z-index: 10;
    }

    .hero-content h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .hero-content p {
        color: #cbd5e1;
        max-width: 600px;
        font-size: 15px;
    }

    /* -----------------------------------------------------------
       4. STATS & SECTION HEADER
    ----------------------------------------------------------- */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h4 {
        font-weight: 700;
        color: #f8fafc;
        font-size: 18px;
    }

    .stats-card {
        background: rgba(30, 41, 59, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 20px;
        border-radius: 20px;
        height: 100%;
    }

    .stats-card small {
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 11px;
    }

    .stats-card h3 {
        font-size: 22px;
        margin-top: 5px;
        font-weight: 800;
        color: #fff;
    }

    /* -----------------------------------------------------------
       5. JADWAL CARDS (FIX 3 KOLOM KE SAMPING)
    ----------------------------------------------------------- */
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* PAKSA 3 KOLOM */
        gap: 20px;
        margin-bottom: 45px;
    }

    .card-jadwal {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 20px;
        transition: 0.3s;
    }

    .card-jadwal:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: translateY(-5px);
        border-color: #4f46e5;
    }

    .date-badge {
        background: #4f46e5;
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 15px;
    }

    .card-jadwal h5 {
        font-size: 18px;
        margin-bottom: 8px;
        font-weight: 700;
        color: #fff;
    }

    .card-jadwal p {
        font-size: 13px;
        color: #94a3b8;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: #cbd5e1;
        margin-top: 5px;
    }

    /* -----------------------------------------------------------
       6. QUICK MENU
    ----------------------------------------------------------- */
    .menu-card {
        background: rgba(30, 41, 59, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 25px 20px;
        border-radius: 20px;
        text-align: center;
        transition: 0.3s;
    }

    .btn-modern {
        display: block;
        padding: 10px;
        border-radius: 10px;
        color: white;
        font-weight: 700;
        text-decoration: none;
        margin-top: 15px;
        font-size: 13px;
    }

    .btn-blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .btn-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .btn-yellow {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .btn-purple {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    /* RESPONSIVE */
    @media (max-width: 1200px) {
        .schedule-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }

        .hero {
            padding: 30px;
            min-height: 250px;
        }

        .hero-content h2 {
            font-size: 24px;
        }
    }

    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>

<div class="topbar">
    <div class="brand">⛪ Digital Church</div>
    <div class="profile-box">👤 {{ auth()->user()->name }}</div>
</div>

<div class="wrapper">
    <div class="sidebar">
        <a href="{{ route('user.home') }}" class="active">🏠 Dashboard</a>
        <a href="{{ route('user.services') }}">📅 Jadwal</a>
        <a href="{{ route('user.pelayanan') }}">🙌 Pelayanan</a>
        <a href="{{ route('user.donation') }}">💰 Donasi</a>
        <a href="{{ route('user.counseling') }}">🧠 Konseling</a>
        <a href="/auto-logout" class="logout">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="hero">
            <div class="hero-content">
                <h2>Shalom, {{ auth()->user()->name }} 👋</h2>
                <p>Tetap terhubung dengan pelayanan dan pertumbuhan imanmu setiap hari ✨</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stats-card">
                    <small>Jadwal Minggu Ini</small>
                    <h3>{{ $totalServices }} Acara</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <small>Status Donasi</small>
                    <h3 style="color: #10b981;">Active</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <small>Pendaftaran</small>
                    <h3 style="color: #38bdf8;">Open</h3>
                </div>
            </div>
        </div>

        <div class="section-header">
            <h4>📅 Jadwal Ibadah Mendatang</h4>
            <a href="{{ route('user.services') }}" style="color: #38bdf8; text-decoration: none; font-size: 13px; font-weight: 600;">Lihat Semua →</a>
        </div>

        <div class="schedule-grid">
            @forelse($services as $service)
            <div class="card-jadwal">
                <div class="date-badge">{{ \Carbon\Carbon::parse($service->date)->translatedFormat('d M Y') }}</div>
                <h5>{{ $service->title }}</h5>
                <p>{{ Str::limit($service->description, 60) }}</p>
                <div class="info-row"><span>🕒</span> {{ $service->time }} WIB</div>
                <div class="info-row"><span>📍</span> {{ $service->location }}</div>
            </div>
            @empty
            <div style="grid-column: span 3; text-align: center; padding: 40px; background: rgba(255,255,255,0.02); border-radius: 20px;">
                <p class="text-muted">Belum ada jadwal terbaru.</p>
            </div>
            @endforelse
        </div>

        <div class="section-header">
            <h4>Layanan Digital</h4>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="menu-card">
                    <h5>Donasi</h5>
                    <a href="{{ route('user.donation') }}" class="btn-modern btn-green">Support</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card">
                    <h5>Pelayanan</h5>
                    <a href="{{ route('user.pelayanan') }}" class="btn-modern btn-yellow">Join Now</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card">
                    <h5>Konseling</h5>
                    <a href="{{ route('user.counseling') }}" class="btn-modern btn-purple">Talk to Us</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card">
                    <h5>Pusat Bantuan</h5>
                    <a href="https://wa.me/6281234567890?text=Shalom%20Admin,%20saya%20butuh%20bantuan%20terkait%20layanan%20Digital%20Church"
                        target="_blank"
                        class="btn-modern btn-blue">
                        Help Center
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection