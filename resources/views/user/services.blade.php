@extends('layouts.user')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #0f172a, #111827);
        color: white;
    }

    /* HEADER */
    .title-page {
        font-size: 42px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .small-text {
        color: #cbd5e1;
        font-size: 16px;
    }

    /* CARD */
    .card-jadwal {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 22px;
        padding: 28px;
        transition: 0.35s ease;
        height: 100%;
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
    }

    .card-jadwal:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        border-color: #22c55e;
    }

    /* TITLE */
    .judul-jadwal {
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
    }

    /* DESC */
    .desc {
        color: #cbd5e1;
        min-height: 55px;
    }

    /* INFO BOX */
    .info-box {
        background: #334155;
        padding: 10px 14px;
        border-radius: 14px;
        margin-bottom: 10px;
        color: #f8fafc;
    }

    /* BADGE */
    .badge-jadwal {
        background: linear-gradient(90deg, #22c55e, #16a34a);
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }

    /* BUTTON */
    .btn-back {
        border-radius: 50px;
        padding: 12px 28px;
        font-weight: 600;
    }

    /* EMPTY */
    .alert-warning {
        border: none;
        background: #f59e0b;
        color: #111827;
    }
</style>

<div class="container py-5">

    <!-- 🔥 BUTTON (KIRI) -->
    <div class="mt-4 mb-3">
        <a href="{{ route('user.home') }}" class="btn btn-outline-light btn-back">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h1 class="title-page">📅 Jadwal Ibadah Gereja</h1>
        <p class="small-text">
            Lihat semua jadwal ibadah, pelayanan, dan kegiatan gereja minggu ini
        </p>
    </div>

    <!-- LIST -->
    <div class="row g-4">

        @forelse($services as $service)

        <div class="col-lg-6">
            <div class="card-jadwal">

                <h3 class="judul-jadwal">
                    {{ $service->title }}
                </h3>

                <p class="desc">
                    {{ $service->description }}
                </p>

                <div class="info-box">
                    🗓️ Tanggal: {{ \Carbon\Carbon::parse($service->date)->format('d M Y') }}
                </div>

                @if(isset($service->time))
                <div class="info-box">
                    ⏰ Jam: {{ $service->time }}
                </div>
                @endif

                @if(isset($service->location))
                <div class="info-box">
                    📍 Lokasi: {{ $service->location }}
                </div>
                @endif

                <span class="badge-jadwal">
                    ✔ Jadwal Tersedia
                </span>

            </div>
        </div>

        @empty

        <div class="col-12">
            <div class="alert alert-warning rounded-4 p-4 text-center">
                <h5>Belum Ada Jadwal</h5>
                <p class="mb-0">Silakan cek kembali nanti ya 🙏</p>
            </div>
        </div>

        @endforelse

    </div>

</div>

@endsection