@extends('layouts.user')

@section('content')

<style>
    body {
        background: radial-gradient(circle at top, #0f172a, #020617);
        color: white;
        font-family: 'Segoe UI', sans-serif;
    }

    /* NAVBAR */
    .topbar {
        background: rgba(2,6,23,0.8);
        backdrop-filter: blur(10px);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #1e293b;
    }

    /* SIDEBAR */
    .sidebar {
        width: 240px;
        background: rgba(2,6,23,0.9);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-right: 1px solid #1e293b;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #94a3b8;
        text-decoration: none;
        padding: 12px;
        border-radius: 12px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: #1e293b;
        color: white;
    }

    .sidebar a.active {
        background: linear-gradient(90deg,#6366f1,#06b6d4);
        color: white;
        box-shadow: 0 0 15px rgba(99,102,241,0.5);
    }

    /* CONTENT */
    .content {
        flex: 1;
        padding: 30px;
    }

    /* HEADER */
    .welcome-box {
        background: linear-gradient(135deg, #6366f1, #06b6d4);
        padding: 25px;
        border-radius: 20px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(99,102,241,0.4);
    }

    /* CARD */
    .card-genz {
        background: rgba(30,41,59,0.9);
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.05);
    }

    .card-genz:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.6);
        border: 1px solid #06b6d4;
    }

    /* MINI CARD */
    .mini-card {
        background: rgba(30,41,59,0.9);
        border-radius: 15px;
        padding: 15px;
        text-align: center;
        transition: 0.3s;
    }

    .mini-card:hover {
        transform: scale(1.05);
    }

    /* BUTTON */
    .btn {
        border-radius: 12px;
        font-weight: 600;
    }

</style>

<!-- NAVBAR -->
<div class="topbar">
    <h5>⛪ Digital Church</h5>
    <div>👤 {{ auth()->user()->name }}</div>
</div>

<div style="display:flex;">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <a href="{{ route('user.home') }}" class="active">🏠 Dashboard</a>
        <a href="{{ route('user.services') }}">📅 Jadwal</a>
        <a href="{{ route('user.pelayanan') }}">🙌 Pelayanan</a>
        <a href="{{ route('user.donation') }}">💰 Donasi</a>
        <a href="{{ route('user.counseling') }}">🧠 Konseling</a>

        <hr style="border-color:#1e293b;">

        <a href="/auto-logout" style="color:#ef4444;">🚪 Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="welcome-box">
            <h3>👋 Halo, {{ auth()->user()->name }}</h3>
            <p>Stay connected dengan pelayanan & imanmu ✨</p>
        </div>

        <!-- STATS -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="mini-card">
                    <h5>📅</h5>
                    <small>Jadwal Minggu Ini</small>
                    <h4>{{ $totalServices }}</h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mini-card">
                    <h5>💰</h5>
                    <small>Donasi</small>
                    <h4>Active</h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mini-card">
                    <h5>🙌</h5>
                    <small>Pelayanan</small>
                    <h4>Open</h4>
                </div>
            </div>
        </div>

        <!-- MENU -->
        <div class="row g-4">

            <div class="col-md-6">
                <div class="card-genz">
                    <h2>📅</h2>
                    <h5>Jadwal</h5>
                    <a href="{{ route('user.services') }}" class="btn btn-primary mt-2">Explore</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-genz">
                    <h2>💰</h2>
                    <h5>Donasi</h5>
                    <a href="{{ route('user.donation') }}" class="btn btn-success mt-2">Support</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-genz">
                    <h2>🙌</h2>
                    <h5>Pelayanan</h5>
                    <a href="{{ route('user.pelayanan') }}" class="btn btn-warning mt-2">Join</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-genz">
                    <h2>🧠</h2>
                    <h5>Konseling</h5>
                    <a href="{{ route('user.counseling') }}" class="btn btn-info mt-2">Talk</a>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection