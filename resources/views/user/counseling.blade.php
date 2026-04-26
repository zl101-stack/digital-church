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
    }

    .card-modern:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
</style>

<div class="container mt-4">

    <h3>🧠 Booking Konseling</h3>

    {{-- FORM --}}
    <div class="card-modern">
        <form action="/counseling" method="POST">
            @csrf

            <select name="pastor_id" class="form-control mb-2" required>
                <option value="">-- Pilih Pastor --</option>
                @foreach($pastors as $pastor)
                    <option value="{{ $pastor->id }}">{{ $pastor->name }}</option>
                @endforeach
            </select>

            <input type="date" name="date" class="form-control mb-2" required>

            <input type="time" name="time" class="form-control mb-2" required>

            <select name="duration" class="form-control mb-2">
                <option value="30">30 Menit</option>
                <option value="60">60 Menit</option>
            </select>

            <textarea name="note" class="form-control mb-2" placeholder="Catatan"></textarea>

            <button class="btn btn-info w-100">
                Booking Sekarang
            </button>
        </form>
    </div>

    {{-- LIST --}}
    <h5 class="mt-4">📋 Jadwal Konseling</h5>

    @foreach($counselings as $c)

    <div class="card-modern">

        <strong>{{ $c->pastor->name ?? '-' }}</strong><br>

        <small>📅 {{ $c->date }}</small><br>
        <small>⏰ {{ $c->time }}</small><br>
        <small>👤 {{ $c->is_anonymous ? 'Anonim' : $c->user->name }}</small>

    </div>

    @endforeach

</div>

@endsection