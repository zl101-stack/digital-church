@extends('layouts.user')

@section('content')

<style>
    .hero-banner {
        background: linear-gradient(to bottom, rgba(2,6,23,0.1), rgba(2,6,23,0.85)),
                    url('{{ asset('gereja.png') }}') center/cover no-repeat;
        border-radius: 20px;
        min-height: 260px;
        display: flex;
        align-items: flex-end;
        padding: 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .hero-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(99,102,241,0.15), transparent);
        border-radius: 20px;
    }
    .hero-text { position: relative; z-index: 1; }
    .hero-text h2 { font-size: 26px; font-weight: 800; margin-bottom: 6px; }
    .hero-text p  { font-size: 14px; color: #cbd5e1; }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-card .val { font-size: 20px; font-weight: 800; }
    .stat-card .lbl { font-size: 12px; color: var(--text-2); margin-top: 2px; }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .section-title a { font-size: 13px; color: #38bdf8; text-decoration: none; font-weight: 500; }

    .jadwal-card {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 14px;
        padding: 18px;
        transition: 0.2s;
        height: 100%;
    }
    .jadwal-card:hover {
        border-color: var(--accent);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(99,102,241,0.15);
    }
    .jadwal-card .date-chip {
        display: inline-block;
        background: rgba(99,102,241,0.15);
        color: #a5b4fc;
        border: 1px solid rgba(99,102,241,0.25);
        border-radius: 8px;
        padding: 3px 10px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .jadwal-card h5 { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
    .jadwal-card .meta { font-size: 12px; color: var(--text-2); display: flex; align-items: center; gap: 6px; margin-top: 5px; }

    .menu-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .menu-item {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 14px;
        padding: 20px 16px;
        text-align: center;
        text-decoration: none;
        color: var(--text-1);
        transition: 0.2s;
        display: block;
    }
    .menu-item:hover { transform: translateY(-3px); color: var(--text-1); }
    .menu-item .menu-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        margin: 0 auto 12px;
    }
    .menu-item .menu-label { font-size: 13px; font-weight: 600; }
    .menu-item .menu-sub   { font-size: 11px; color: var(--text-2); margin-top: 3px; }

    @media (max-width: 768px) {
        .menu-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

{{-- HERO --}}
<div class="hero-banner">
    <div class="hero-text">
        <h2>Shalom, {{ auth()->user()->name }} 👋</h2>
        <p>Tetap terhubung dengan pelayanan dan pertumbuhan imanmu setiap hari ✨</p>
    </div>
</div>

{{-- STATS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(99,102,241,0.15);">📅</div>
            <div>
                <div class="val">{{ $totalServices }}</div>
                <div class="lbl">Jadwal Tersedia</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(34,197,94,0.15);">💖</div>
            <div>
                <div class="val" style="color:#86efac;">Aktif</div>
                <div class="lbl">Status Donasi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(56,189,248,0.15);">🙌</div>
            <div>
                <div class="val" style="color:#7dd3fc;">Open</div>
                <div class="lbl">Pendaftaran Pelayanan</div>
            </div>
        </div>
    </div>
</div>

{{-- JADWAL --}}
<div class="section-title">
    <span>📅 Jadwal Ibadah Mendatang</span>
    <a href="{{ route('user.services') }}">Lihat Semua →</a>
</div>
<div class="row g-3 mb-5">
    @forelse($services as $service)
    <div class="col-md-4">
        <div class="jadwal-card">
            <div class="date-chip">{{ \Carbon\Carbon::parse($service->date)->translatedFormat('d M Y') }}</div>
            <h5>{{ $service->title }}</h5>
            <div class="meta">🕒 {{ $service->time }} WIB</div>
            <div class="meta">📍 {{ $service->location }}</div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="u-card p-5 text-center" style="color:var(--text-3);">
            <div style="font-size:40px;opacity:0.3;margin-bottom:10px;">📅</div>
            <p>Belum ada jadwal terbaru.</p>
        </div>
    </div>
    @endforelse
</div>

{{-- QUICK MENU --}}
<div class="section-title"><span>Layanan Digital</span></div>
<div class="menu-grid">
    <a href="{{ route('user.donation') }}" class="menu-item" style="border-color:rgba(34,197,94,0.2);">
        <div class="menu-icon" style="background:rgba(34,197,94,0.12);">💖</div>
        <div class="menu-label">Donasi</div>
        <div class="menu-sub">Berikan persembahan</div>
    </a>
    <a href="{{ route('user.pelayanan') }}" class="menu-item" style="border-color:rgba(245,158,11,0.2);">
        <div class="menu-icon" style="background:rgba(245,158,11,0.12);">🙌</div>
        <div class="menu-label">Pelayanan</div>
        <div class="menu-sub">Daftar tim pelayanan</div>
    </a>
    <a href="{{ route('user.counseling') }}" class="menu-item" style="border-color:rgba(139,92,246,0.2);">
        <div class="menu-icon" style="background:rgba(139,92,246,0.12);">🧠</div>
        <div class="menu-label">Konseling</div>
        <div class="menu-sub">Booking sesi konseling</div>
    </a>
    <a href="https://wa.me/6281234567890" target="_blank" class="menu-item" style="border-color:rgba(56,189,248,0.2);">
        <div class="menu-icon" style="background:rgba(56,189,248,0.12);">💬</div>
        <div class="menu-label">Bantuan</div>
        <div class="menu-sub">Hubungi admin</div>
    </a>
</div>

@endsection
