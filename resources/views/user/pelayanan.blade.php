@extends('layouts.user')

@section('content')

<style>
    body {
        background: #0f172a;
        color: white;
    }

    .card-modern {
        background: #1e293b;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        transition: 0.3s;
        cursor: pointer;
    }

    .card-modern:hover {
        transform: scale(1.03);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }

    .badge-open {
        background: #22c55e;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .badge-taken {
        background: #ef4444;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }
</style>

<div class="container mt-4">

    {{-- 🔥 TAMBAHAN DI SINI --}}
    <div class="mb-3">
        <a href="{{ route('user.home') }}" class="btn btn-outline-light">
            ⬅️ Kembali ke Dashboard
        </a>
    </div>

    <h3>🙌 Pelayanan Gereja</h3>

    {{-- 🔥 NOTIF --}}
    @if(session('error'))
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif


    {{-- ========================
        JADWAL TERSEDIA
    ======================== --}}
    <h5 class="mt-4">📅 Jadwal Tersedia</h5>

    <div class="row">

        @foreach($services as $service)

        @php
            $total = count($service->registrations);

            $alreadyRegistered = $service->registrations
                ->where('user_id', auth()->id())
                ->count();
        @endphp

        <div class="col-md-6">

            <div class="card-modern"
                 data-bs-toggle="modal"
                 data-bs-target="#modalService{{ $service->id }}">

                <h5>{{ $service->title }}</h5>
                <p>{{ $service->location }}</p>

                <small>📅 {{ $service->date }}</small><br>
                <small>⏰ {{ $service->time }}</small><br><br>

                <small>{{ $total }}/4 slot terisi</small>

                <div class="text-end mt-2">
                    @if($alreadyRegistered)
                        <span class="badge-taken">SUDAH TERDAFTAR</span>
                    @else
                        <span class="badge-open">OPEN</span>
                    @endif
                </div>

            </div>

        </div>

        <div class="modal fade" id="modalService{{ $service->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white p-3">

                    <h5>{{ $service->title }}</h5>
                    <p>{{ $service->date }}</p>

                    @if($alreadyRegistered)
                        <div class="alert alert-warning">
                            ⚠️ Kamu sudah mengambil posisi di jadwal ini
                        </div>
                    @endif

                    <form action="{{ route('user.pelayanan.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="name" value="{{ auth()->user()->name }}">

                        @php
                            $taken = $service->registrations->pluck('position')->toArray();
                            $positions = ['Vokalis','Gitar','Drummer','Sound System'];
                        @endphp

                        @foreach($positions as $pos)

                        <div class="form-check mb-2">

                            <input type="radio"
                                   name="position"
                                   value="{{ $pos }}"
                                   class="form-check-input"
                                   {{ in_array($pos, $taken) || $alreadyRegistered ? 'disabled' : '' }}>

                            <label class="form-check-label">
                                {{ $pos }}

                                @if(in_array($pos, $taken))
                                    ❌ Sudah diambil
                                @elseif($alreadyRegistered)
                                    🔒 Tidak bisa pilih lagi
                                @else
                                    ✅ Tersedia
                                @endif
                            </label>

                        </div>

                        @endforeach

                        <button class="btn btn-success w-100 mt-3"
                            {{ $alreadyRegistered ? 'disabled' : '' }}>
                            Simpan Pelayanan
                        </button>

                    </form>

                </div>
            </div>
        </div>

        @endforeach

    </div>


    <h5 class="mt-5">👥 Tim Pelayanan</h5>

    @foreach($services as $service)

    <div class="card-modern">

        <h5>{{ $service->title }}</h5>

        @forelse($service->registrations as $reg)

        <div class="d-flex justify-content-between">
            <span>{{ $reg->name }}</span>
            <span>🎯 {{ $reg->position }}</span>
        </div>

        @empty
            <p class="text-muted">Belum ada pelayan</p>
        @endforelse

    </div>

    @endforeach

</div>

@endsection