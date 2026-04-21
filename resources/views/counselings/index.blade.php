@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">🗓️ Booking Konseling</h2>

    <!-- FORM BOOKING -->
    <div class="card p-4">

        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="/counseling" method="POST">
            @csrf

            <select name="pastor_id" class="form-control mb-2" required>
                <option value="">-- Pilih Pastor --</option>
                @foreach($pastors as $pastor)
                <option value="{{ $pastor->id }}">
                    {{ $pastor->name }}
                </option>
                @endforeach
            </select>

            <input type="date" name="date" class="form-control mb-2" required>

            <input type="time" name="time" class="form-control mb-2" required>

            <select name="duration" class="form-control mb-2">
                <option value="30">30 Menit</option>
                <option value="60">1 Jam</option>
            </select>

            <textarea name="note" class="form-control mb-2" placeholder="Catatan (opsional)"></textarea>

            <div class="form-check mb-2">
                <input type="checkbox" name="is_anonymous" class="form-check-input">
                <label class="form-check-label">Anonim</label>
            </div>

            <button class="btn btn-primary w-100">Booking Konseling</button>

        </form>

    </div>

    <hr class="my-4">

    <!-- TABLE DATA -->
    <h4>📋 Daftar Booking Konseling</h4>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Pastor</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Nama</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($counselings as $counseling)
            <tr>
                <td>{{ $counseling->pastor->name ?? '-' }}</td>
                <td>{{ $counseling->date }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($counseling->time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($counseling->time)->addMinutes($counseling->duration)->format('H:i') }}
                </td>
                <td>
                    @if($counseling->is_anonymous)
                    <span class="badge bg-secondary">Anonim</span>
                    @else
                    {{ $counseling->user->name ?? '-' }}
                    @endif
                </td>

                <td>{{ $counseling->note }}</td>

                <!-- AKSI -->
                <td>
                    <a href="/counseling/{{ $counseling->id }}/edit" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="/counseling/{{ $counseling->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">
                            Hapus
                        </button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection