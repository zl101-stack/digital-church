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
        cursor: pointer;
        transition: 0.3s;
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
</style>

<div class="container mt-4">

    <h3>🧠 Konseling Gereja</h3>

    {{-- 🔥 NOTIF ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- 🔥 NOTIF SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ========================
        LIST PASTOR
    ======================== --}}
    <div class="row">

        @foreach($pastors as $pastor)

        <div class="col-md-6">

            <div class="card-modern"
                 data-bs-toggle="modal"
                 data-bs-target="#modalPastor{{ $pastor->id }}">

                <h5>👤 {{ $pastor->name }}</h5>
                <p>Klik untuk booking konseling</p>

                <div class="text-end">
                    <span class="badge-open">BOOK</span>
                </div>

            </div>

        </div>

        {{-- ========================
            MODAL BOOKING
        ======================== --}}
        <div class="modal fade" id="modalPastor{{ $pastor->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white p-3">

                    <h5>Booking dengan {{ $pastor->name }}</h5>

                    <form action="{{ route('user.counseling.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="pastor_id" value="{{ $pastor->id }}">

                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control mb-2" required>

                        <label>Jam</label>
                        <input type="time" name="time" class="form-control mb-2" required>

                        <label>Durasi</label>
                        <select name="duration" class="form-control mb-2">
                            <option value="30">30 Menit</option>
                            <option value="60">60 Menit</option>
                        </select>

                        <textarea name="note" class="form-control mb-2" placeholder="Catatan"></textarea>

                        <div class="form-check mb-2">
                            <input type="checkbox" name="is_anonymous" class="form-check-input">
                            <label>Booking sebagai anonim</label>
                        </div>

                        <button class="btn btn-info w-100">
                            Booking Sekarang
                        </button>

                    </form>

                </div>
            </div>
        </div>

        @endforeach

    </div>

    {{-- ========================
        LOG BOOKING
    ======================== --}}
    <h5 class="mt-5">📋 Riwayat Konseling</h5>

    @foreach($counselings as $c)

    <div class="card-modern">

        <strong>{{ $c->pastor->name ?? '-' }}</strong><br>

        <small>📅 {{ $c->date }}</small><br>

        <small>
            ⏰ {{ \Carbon\Carbon::parse($c->time)->format('H:i') }} - 
            {{ \Carbon\Carbon::parse($c->time)->addMinutes($c->duration)->format('H:i') }}
        </small><br>

        <small>
            👤 {{ $c->is_anonymous ? 'Anonim' : $c->user->name }}
        </small>

    </div>

    @endforeach

</div>

@endsection