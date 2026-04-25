@extends('layouts.user')

@section('content')

<style>
    .welcome-box {
        background: linear-gradient(135deg, #6366f1, #06b6d4);
        padding: 25px;
        border-radius: 20px;
        margin-bottom: 20px;
    }

    .card-genz {
        background: #1e293b;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        transition: 0.3s;
        color: white;
    }

    .card-genz:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .notif-card {
        background: #1e293b;
        border-radius: 20px;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
    }

    .notif-item {
        border-bottom: 1px solid #334155;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .badge-new {
        background: #22c55e;
        font-size: 10px;
        padding: 3px 6px;
        border-radius: 10px;
        margin-left: 5px;
    }

    .mini-card {
        background: #1e293b;
        border-radius: 15px;
        padding: 15px;
        text-align: center;
        color: white;
    }
</style>

<!-- 🔥 HEADER -->
<div class="welcome-box">
    <h3>👋 Halo, {{ auth()->user()->name }}</h3>
    <p class="mb-0">Stay connected dengan pelayanan & imanmu ✨</p>
</div>

<div class="row">

    <!-- 🔔 LEFT SIDE (NOTIF + INFO) -->
    <div class="col-md-4">

        <!-- 🔔 JADWAL -->
        <div class="notif-card">
            <h5>🔔 Jadwal Terbaru</h5>

            @if(isset($services) && count($services) > 0)

            @foreach($services as $service)
            <div class="notif-item">
                <strong>{{ $service->title }}</strong>
                <span class="badge-new">NEW</span><br>
                <small class="text-muted">{{ $service->date }}</small>
            </div>
            @endforeach

            @else
            <p class="text-muted">Belum ada jadwal</p>
            @endif
        </div>

        <!-- 🙌 PELAYANAN AVAILABLE -->
        <div class="notif-card">
            <h5>🙌 Pelayanan Available</h5>

            <div class="notif-item">
                Worship Team
                <span class="badge-new">OPEN</span>
            </div>

            <div class="notif-item">
                Multimedia
                <span class="badge-new">OPEN</span>
            </div>

            <div class="notif-item">
                Singer / Musician
                <span class="badge-new">OPEN</span>
            </div>
        </div>

    </div>

    <!-- 🔥 RIGHT SIDE (MAIN DASHBOARD) -->
    <div class="col-md-8">

        <!-- 📊 MINI STATS -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="mini-card">
                    <h5>📅</h5>
                    <small>Jadwal Minggu Ini</small>
                    <h4>{{ count($services ?? []) }}</h4>
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

        <!-- 🔥 MENU -->
        <div class="row g-3">

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
                    <a href="/counseling" class="btn btn-info mt-2">Talk</a>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection